<?php
namespace iuf\junia\action;

use iuf\junia\analyzer\PerformanceAnalyzer;
use iuf\junia\importer\ImporterFactory;
use iuf\junia\model\EventQuery;
use iuf\junia\model\StartgroupQuery;
use keeko\framework\domain\payload\Failed;
use keeko\framework\domain\payload\Success;
use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Import data
 * 
 * This code is automatically created. Modifications will probably be overwritten.
 * 
 * @author gossi
 */
class ImportAction extends AbstractAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		try {
			$file = $request->files->get('file');
			
			// check proper upload
			if (!$file->isValid()) {
				throw new \Exception('Something went wrong during file upload');
			}
			
			// check extension
			$exts = ['csv'];
			$extMatch = false;
			foreach ($exts as $ext) {
				if (strtolower($file->getClientOriginalExtension()) == $ext) {
					$extMatch = true;
				}
			}
			
			if (!$extMatch) {
				throw new \Exception('No matching extension');
			}
			
			// check event
			if (!$request->request->has('event-id')) {
				throw new \Exception('No event-id given');
			}
			
			// check importer
			if (!$request->request->has('importer')) {
				throw new \Exception('No importer given');
			}
			
			// clean event
			$event = EventQuery::create()->findOneById($request->request->get('event-id'));
			
			// clean startgroups
			foreach (StartgroupQuery::create()->filterByEvent($event) as $startgroup) {
				foreach ($startgroup->getRoutines() as $routine) {
					$this->deleteStatistics($routine);
				}
				$this->deleteStatistics($startgroup);
			}
			$this->deleteStatistics($event);
			StartgroupQuery::create()->filterByEvent($event)->delete();
			
			$body = file_get_contents($file->getPathname());
			$importer = ImporterFactory::generateImporter($request->request->get('importer'));
			$importer->import($body, $event);
			
			// analyze after import
			$analyzer = new PerformanceAnalyzer();
			$analyzer->analyze($event);
			
			$payload = new Success();
		} catch (\Exception $e) {
			$payload = new Failed(['exception' => $e]);
		}
		
		return $this->responder->run($request, $payload);
	}
	
	private function deleteStatistics($model) {
		$targets = ['Total', 'Execution', 'Choreography', 'MusicAndTiming'];
		
		foreach ($targets as $target) {
			$getter = sprintf('getPerformance%sStatistic', $target);
			if (method_exists($model, $getter)) {
				$statistic = $model->$getter();
				if ($statistic !== null) {
					$statistic->delete();
				}
			}
		}
	}
}

<?php
namespace iuf\junia\action;

use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use keeko\framework\domain\payload\Failed;
use iuf\junia\analyzer\PerformanceAnalyzer;
use iuf\junia\model\EventQuery;
use keeko\framework\domain\payload\Success;

/**
 * Analyze and create statistics on an event
 * 
 * This code is automatically created. Modifications will probably be overwritten.
 * 
 * @author gossi
 */
class AnalyzeAction extends AbstractAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		if ($request->request->has('event-id')) {
			$event = EventQuery::create()->findOneById($request->request->get('event-id'));
			$analyzer = new PerformanceAnalyzer();
			$analyzer->analyze($event);
			$payload = new Success();
		} else {
			$payload = new Failed(['exception' => new \Exception('No event-id given')]);
		}

		return $this->responder->run($request, $payload);
	}
}

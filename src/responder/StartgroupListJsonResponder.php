<?php
namespace iuf\junia\responder;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use keeko\framework\foundation\AbstractPayloadResponder;
use iuf\junia\model\Startgroup;
use iuf\junia\model\Competition;
use iuf\junia\model\Event;
use iuf\junia\model\PerformanceStatistic;
use iuf\junia\model\Routine;
use iuf\junia\model\Judge;
use keeko\framework\domain\payload\Found;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Collection;
use Tobscure\JsonApi\Parameters;

/**
 * Automatically generated JsonResponder for List all startgroups
 * 
 * @author gossi
 */
class StartgroupListJsonResponder extends AbstractPayloadResponder {

	/**
	 * @param Request $request
	 * @param Found $payload
	 */
	public function found(Request $request, Found $payload) {
		$params = new Parameters($request->query->all());
		$data = $payload->getModel();
		$serializer = Startgroup::getSerializer();
		$resource = new Collection($data, $serializer);
		$resource = $resource->with($params->getInclude(['competition', 'event', 'performance-total-statistic', 'performance-execution-statistic', 'performance-choreography-statistic', 'performance-music-and-timing-statistic', 'routines', 'judges', 'routines.performance-total-statistic', 'routines.performance-execution-statistic', 'routines.performance-choreography-statistic', 'routines.performance-music-and-timing-statistic', 'routines.performance-scores', 'routines.performance-scores.judge']));
		$resource = $resource->fields($params->getFields([
			'startgroup' => Startgroup::getSerializer()->getFields(),
			'competition' => Competition::getSerializer()->getFields(),
			'event' => Event::getSerializer()->getFields(),
			'performance-total-statistic' => PerformanceStatistic::getSerializer()->getFields(),
			'performance-execution-statistic' => PerformanceStatistic::getSerializer()->getFields(),
			'performance-choreography-statistic' => PerformanceStatistic::getSerializer()->getFields(),
			'performance-music-and-timing-statistic' => PerformanceStatistic::getSerializer()->getFields(),
			'routine' => Routine::getSerializer()->getFields(),
			'judge' => Judge::getSerializer()->getFields()
		]));
		$document = new Document($resource);

		// meta
		$document->setMeta([
			'total' => $data->getNbResults(),
			'first' => $data->getFirstPage(),
			'next' => $data->getNextPage(),
			'previous' => $data->getPreviousPage(),
			'last' => $data->getLastPage()
		]);

		// return response
		return new JsonResponse($document->toArray());
	}

	/**
	 */
	protected function getPayloadMethods() {
		return [
			'keeko\framework\domain\payload\Found' => 'found'
		];
	}
}

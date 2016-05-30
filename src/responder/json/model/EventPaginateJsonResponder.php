<?php
namespace iuf\junia\responder\json\model;

use iuf\junia\model\Event;
use iuf\junia\model\PerformanceStatistic;
use iuf\junia\model\Startgroup;
use keeko\framework\domain\payload\Found;
use keeko\framework\foundation\AbstractPayloadResponder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Tobscure\JsonApi\Collection;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Parameters;

/**
 * Automatically generated JsonResponder for Paginates events
 * 
 * @author gossi
 */
class EventPaginateJsonResponder extends AbstractPayloadResponder {

	/**
	 * @param Request $request
	 * @param Found $payload
	 */
	public function found(Request $request, Found $payload) {
		$params = new Parameters($request->query->all());
		$data = $payload->getModel();
		$serializer = Event::getSerializer();
		$resource = new Collection($data, $serializer);
		$resource = $resource->with($params->getInclude(['performance-total-statistic', 'performance-execution-statistic', 'performance-choreography-statistic', 'performance-music-and-timing-statistic', 'startgroups', 'startgroups.competition', 'startgroups.performance-total-statistic', 'startgroups.performance-execution-statistic', 'startgroups.performance-choreography-statistic', 'startgroups.performance-music-and-timing-statistic']));
		$resource = $resource->fields($params->getFields([
			'event' => Event::getSerializer()->getFields(),
			'performance-total-statistic' => PerformanceStatistic::getSerializer()->getFields(),
			'performance-execution-statistic' => PerformanceStatistic::getSerializer()->getFields(),
			'performance-choreography-statistic' => PerformanceStatistic::getSerializer()->getFields(),
			'performance-music-and-timing-statistic' => PerformanceStatistic::getSerializer()->getFields(),
			'startgroup' => Startgroup::getSerializer()->getFields()
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

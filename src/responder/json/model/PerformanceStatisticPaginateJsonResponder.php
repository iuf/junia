<?php
namespace iuf\junia\responder\json\model;

use iuf\junia\model\Event;
use iuf\junia\model\PerformanceStatistic;
use iuf\junia\model\Routine;
use iuf\junia\model\Startgroup;
use keeko\framework\domain\payload\Found;
use keeko\framework\foundation\AbstractPayloadResponder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Tobscure\JsonApi\Collection;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Parameters;

/**
 * Automatically generated JsonResponder for Paginates performance_statistics
 * 
 * @author gossi
 */
class PerformanceStatisticPaginateJsonResponder extends AbstractPayloadResponder {

	/**
	 * @param Request $request
	 * @param Found $payload
	 */
	public function found(Request $request, Found $payload) {
		$params = new Parameters($request->query->all());
		$data = $payload->getModel();
		$serializer = PerformanceStatistic::getSerializer();
		$resource = new Collection($data, $serializer);
		$resource = $resource->with($params->getInclude(['events', 'startgroups', 'routine']));
		$resource = $resource->fields($params->getFields([
			'performance-statistic' => PerformanceStatistic::getSerializer()->getFields(),
			'event' => Event::getSerializer()->getFields(),
			'startgroup' => Startgroup::getSerializer()->getFields(),
			'routine' => Routine::getSerializer()->getFields()
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

<?php
namespace iuf\junia\responder\json\model;

use iuf\junia\model\Event;
use iuf\junia\model\PerformanceStatistic;
use iuf\junia\model\Routine;
use iuf\junia\model\Startgroup;
use keeko\framework\domain\payload\Found;
use keeko\framework\domain\payload\NotFound;
use keeko\framework\foundation\AbstractPayloadResponder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Parameters;
use Tobscure\JsonApi\Resource;

/**
 * Automatically generated JsonResponder for Reads a performance_statistic
 * 
 * @author gossi
 */
class PerformanceStatisticReadJsonResponder extends AbstractPayloadResponder {

	/**
	 * @param Request $request
	 * @param Found $payload
	 */
	public function found(Request $request, Found $payload) {
		$params = new Parameters($request->query->all());
		$serializer = PerformanceStatistic::getSerializer();
		$resource = new Resource($payload->getModel(), $serializer);
		$resource = $resource->with($params->getInclude(['events', 'startgroups', 'routine']));
		$resource = $resource->fields($params->getFields([
			'performance-statistic' => PerformanceStatistic::getSerializer()->getFields(),
			'event' => Event::getSerializer()->getFields(),
			'startgroup' => Startgroup::getSerializer()->getFields(),
			'routine' => Routine::getSerializer()->getFields()
		]));
		$document = new Document($resource);

		return new JsonResponse($document->toArray(), 200);
	}

	/**
	 * @param Request $request
	 * @param NotFound $payload
	 */
	public function notFound(Request $request, NotFound $payload) {
		throw new ResourceNotFoundException($payload->getMessage());
	}

	/**
	 */
	protected function getPayloadMethods() {
		return [
			'keeko\framework\domain\payload\Found' => 'found',
			'keeko\framework\domain\payload\NotFound' => 'notFound'
		];
	}
}

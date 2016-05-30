<?php
namespace iuf\junia\responder\json\model;

use iuf\junia\model\Judge;
use iuf\junia\model\PerformanceScore;
use iuf\junia\model\Startgroup;
use keeko\core\model\User;
use keeko\framework\domain\payload\Found;
use keeko\framework\foundation\AbstractPayloadResponder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Tobscure\JsonApi\Collection;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Parameters;

/**
 * Automatically generated JsonResponder for Paginates judges
 * 
 * @author gossi
 */
class JudgePaginateJsonResponder extends AbstractPayloadResponder {

	/**
	 * @param Request $request
	 * @param Found $payload
	 */
	public function found(Request $request, Found $payload) {
		$params = new Parameters($request->query->all());
		$data = $payload->getModel();
		$serializer = Judge::getSerializer();
		$resource = new Collection($data, $serializer);
		$resource = $resource->with($params->getInclude(['startgroup', 'user', 'performance-score']));
		$resource = $resource->fields($params->getFields([
			'judge' => Judge::getSerializer()->getFields(),
			'startgroup' => Startgroup::getSerializer()->getFields(),
			'user' => User::getSerializer()->getFields(),
			'performance-score' => PerformanceScore::getSerializer()->getFields()
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

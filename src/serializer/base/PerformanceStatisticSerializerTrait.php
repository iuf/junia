<?php
namespace iuf\junia\serializer\base;

use keeko\framework\utils\HydrateUtils;
use Tobscure\JsonApi\Relationship;
use iuf\junia\model\Routine;
use Tobscure\JsonApi\Resource;

/**
 */
trait PerformanceStatisticSerializerTrait {

	/**
	 * @param mixed $model
	 * @param array $fields
	 */
	public function getAttributes($model, array $fields = null) {
		return [
			'id' => $model->getId(),
			'min' => $model->getMin(),
			'max' => $model->getMax(),
			'range' => $model->getRange(),
			'average' => $model->getAverage(),
			'standard-deviation' => $model->getStandardDeviation(),
			'variance' => $model->getVariance(),
		];
	}

	/**
	 */
	public function getFields() {
		return ['id', 'min', 'max', 'range', 'average', 'standard-deviation', 'variance'];
	}

	/**
	 * @param mixed $model
	 * @return string
	 */
	public function getId($model) {
		return $model->getId();
	}

	/**
	 */
	public function getRelationships() {
		return [
			'routine' => Routine::getSerializer()->getType(null)
		];
	}

	/**
	 */
	public function getSortFields() {
		return ['id', 'min', 'max', 'range', 'average', 'standard-deviation', 'variance'];
	}

	/**
	 * @param mixed $model
	 * @return string
	 */
	public function getType($model) {
		return 'junia/performance-statistic';
	}

	/**
	 * @param mixed $model
	 * @param mixed $data
	 * @return mixed The model
	 */
	public function hydrate($model, $data) {
		// attributes
		$attribs = isset($data['attributes']) ? $data['attributes'] : [];

		$model = HydrateUtils::hydrate($attribs, $model, ['id', 'min', 'max', 'range', 'average', 'standard-deviation', 'variance']);

		// relationships
		$this->hydrateRelationships($model, $data);

		return $model;
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function routine($model) {
		$serializer = Routine::getSerializer();
		$relationship = new Relationship(new Resource($model->getRoutine(), $serializer));
		$relationship->setLinks([
			'related' => '%apiurl%' . $serializer->getType(null) . '/' . $serializer->getId($model)
		]);
		return $this->addRelationshipSelfLink($relationship, $model, 'routine');
	}

	/**
	 * @param Relationship $relationship
	 * @param mixed $model
	 * @param string $related
	 * @return Relationship
	 */
	abstract protected function addRelationshipSelfLink(Relationship $relationship, $model, $related);

	/**
	 * @param mixed $model
	 * @param mixed $data
	 * @return void
	 */
	abstract protected function hydrateRelationships($model, $data);
}

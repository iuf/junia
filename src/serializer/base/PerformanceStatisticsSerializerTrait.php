<?php
namespace iuf\junia\serializer\base;

use keeko\framework\utils\HydrateUtils;

/**
 */
trait PerformanceStatisticsSerializerTrait {

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
			'standard_deviation' => $model->getStandardDeviation(),
			'variance' => $model->getVariance(),
		];
	}

	/**
	 */
	public function getFields() {
		return ['id', 'min', 'max', 'range', 'average', 'standard_deviation', 'variance'];
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
		];
	}

	/**
	 */
	public function getSortFields() {
		return ['id', 'min', 'max', 'range', 'average', 'standard_deviation', 'variance'];
	}

	/**
	 * @param mixed $model
	 * @return string
	 */
	public function getType($model) {
		return 'junia/performance-statistics';
	}

	/**
	 * @param mixed $model
	 * @param mixed $data
	 * @return mixed The model
	 */
	public function hydrate($model, $data) {
		// attributes
		$attribs = isset($data['attributes']) ? $data['attributes'] : [];

		$model = HydrateUtils::hydrate($attribs, $model, ['id', 'min', 'max', 'range', 'average', 'standard_deviation', 'variance']);

		// relationships
		$this->hydrateRelationships($model, $data);

		return $model;
	}

	/**
	 * @param mixed $model
	 * @param mixed $data
	 * @return void
	 */
	abstract protected function hydrateRelationships($model, $data);
}

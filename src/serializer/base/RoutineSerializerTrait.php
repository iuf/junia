<?php
namespace iuf\junia\serializer\base;

use keeko\framework\utils\HydrateUtils;
use Tobscure\JsonApi\Relationship;
use iuf\junia\model\Startgroup;
use Tobscure\JsonApi\Resource;
use iuf\junia\model\PerformanceStatistics;

/**
 */
trait RoutineSerializerTrait {

	/**
	 * @param mixed $model
	 * @param array $fields
	 */
	public function getAttributes($model, array $fields = null) {
		return [
			'id' => $model->getId(),
			'name' => $model->getName(),
			'startgroup_id' => $model->getStartgroupId(),
			'performance_total_statistics_id' => $model->getPerformanceTotalStatisticsId(),
			'performance_execution_statistics_id' => $model->getPerformanceExecutionStatisticsId(),
			'performance_choreography_statistics_id' => $model->getPerformanceChoreographyStatisticsId(),
			'performance_music_and_timing_statistics_id' => $model->getPerformanceMusicAndTimingStatisticsId(),
		];
	}

	/**
	 */
	public function getFields() {
		return ['id', 'name', 'startgroup_id', 'performance_total_statistics_id', 'performance_execution_statistics_id', 'performance_choreography_statistics_id', 'performance_music_and_timing_statistics_id'];
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
			'startgroup' => Startgroup::getSerializer()->getType(null),
			'performance-statistics' => PerformanceStatistics::getSerializer()->getType(null)
		];
	}

	/**
	 */
	public function getSortFields() {
		return ['id', 'name', 'startgroup_id', 'performance_total_statistics_id', 'performance_execution_statistics_id', 'performance_choreography_statistics_id', 'performance_music_and_timing_statistics_id'];
	}

	/**
	 * @param mixed $model
	 * @return string
	 */
	public function getType($model) {
		return 'junia/routine';
	}

	/**
	 * @param mixed $model
	 * @param mixed $data
	 * @return mixed The model
	 */
	public function hydrate($model, $data) {
		// attributes
		$attribs = isset($data['attributes']) ? $data['attributes'] : [];

		$model = HydrateUtils::hydrate($attribs, $model, ['id', 'name', 'startgroup_id', 'performance_total_statistics_id', 'performance_execution_statistics_id', 'performance_choreography_statistics_id', 'performance_music_and_timing_statistics_id']);

		// relationships
		$this->hydrateRelationships($model, $data);

		return $model;
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function performanceStatistics($model) {
		$serializer = PerformanceStatistics::getSerializer();
		$relationship = new Relationship(new Resource($model->getPerformanceStatistics(), $serializer));
		$relationship->setLinks([
			'related' => '%apiurl%' . $serializer->getType(null) . '/' . $serializer->getId($model)
		]);
		return $this->addRelationshipSelfLink($relationship, $model, 'performance-statistics');
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function startgroup($model) {
		$serializer = Startgroup::getSerializer();
		$relationship = new Relationship(new Resource($model->getStartgroup(), $serializer));
		$relationship->setLinks([
			'related' => '%apiurl%' . $serializer->getType(null) . '/' . $serializer->getId($model)
		]);
		return $this->addRelationshipSelfLink($relationship, $model, 'startgroup');
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

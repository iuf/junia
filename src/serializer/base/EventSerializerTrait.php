<?php
namespace iuf\junia\serializer\base;

use keeko\framework\utils\HydrateUtils;
use Tobscure\JsonApi\Relationship;
use iuf\junia\model\PerformanceStatistic;
use Tobscure\JsonApi\Resource;
use iuf\junia\model\Startgroup;
use Tobscure\JsonApi\Collection;

/**
 */
trait EventSerializerTrait {

	/**
	 * @param mixed $model
	 * @param array $fields
	 */
	public function getAttributes($model, array $fields = null) {
		return [
			'id' => $model->getId(),
			'name' => $model->getName(),
			'start' => $model->getStart(\DateTime::ISO8601),
			'end' => $model->getEnd(\DateTime::ISO8601),
			'performance-total-statistic-id' => $model->getPerformanceTotalStatisticId(),
			'performance-execution-statistic-id' => $model->getPerformanceExecutionStatisticId(),
			'performance-choreography-statistic-id' => $model->getPerformanceChoreographyStatisticId(),
			'performance-music-and-timing-statistic-id' => $model->getPerformanceMusicAndTimingStatisticId(),
			'slug' => $model->getSlug(),
		];
	}

	/**
	 */
	public function getFields() {
		return ['id', 'name', 'start', 'end', 'performance-total-statistic-id', 'performance-execution-statistic-id', 'performance-choreography-statistic-id', 'performance-music-and-timing-statistic-id', 'slug'];
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
			'performance-total-statistic' => PerformanceStatistic::getSerializer()->getType(null),
			'performance-execution-statistic' => PerformanceStatistic::getSerializer()->getType(null),
			'performance-choreography-statistic' => PerformanceStatistic::getSerializer()->getType(null),
			'performance-music-and-timing-statistic' => PerformanceStatistic::getSerializer()->getType(null),
			'startgroups' => Startgroup::getSerializer()->getType(null)
		];
	}

	/**
	 */
	public function getSortFields() {
		return ['id', 'name', 'start', 'end', 'performance-total-statistic-id', 'performance-execution-statistic-id', 'performance-choreography-statistic-id', 'performance-music-and-timing-statistic-id', 'slug'];
	}

	/**
	 * @param mixed $model
	 * @return string
	 */
	public function getType($model) {
		return 'iuf.junia/event';
	}

	/**
	 * @param mixed $model
	 * @param mixed $data
	 * @return mixed The model
	 */
	public function hydrate($model, $data) {
		// attributes
		$attribs = isset($data['attributes']) ? $data['attributes'] : [];

		$model = HydrateUtils::hydrate($attribs, $model, ['id', 'name', 'start', 'end', 'performance-total-statistic-id', 'performance-execution-statistic-id', 'performance-choreography-statistic-id', 'performance-music-and-timing-statistic-id', 'slug']);

		// relationships
		$this->hydrateRelationships($model, $data);

		return $model;
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function performanceChoreographyStatistic($model) {
		$serializer = PerformanceStatistic::getSerializer();
		$relationship = new Relationship(new Resource($model->getPerformanceChoreographyStatistic(), $serializer));
		$relationship->setLinks([
			'related' => '%apiurl%' . $serializer->getType(null) . '/' . $serializer->getId($model)
		]);
		return $this->addRelationshipSelfLink($relationship, $model, 'performance-choreography-statistic');
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function performanceExecutionStatistic($model) {
		$serializer = PerformanceStatistic::getSerializer();
		$relationship = new Relationship(new Resource($model->getPerformanceExecutionStatistic(), $serializer));
		$relationship->setLinks([
			'related' => '%apiurl%' . $serializer->getType(null) . '/' . $serializer->getId($model)
		]);
		return $this->addRelationshipSelfLink($relationship, $model, 'performance-execution-statistic');
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function performanceMusicAndTimingStatistic($model) {
		$serializer = PerformanceStatistic::getSerializer();
		$relationship = new Relationship(new Resource($model->getPerformanceMusicAndTimingStatistic(), $serializer));
		$relationship->setLinks([
			'related' => '%apiurl%' . $serializer->getType(null) . '/' . $serializer->getId($model)
		]);
		return $this->addRelationshipSelfLink($relationship, $model, 'performance-music-and-timing-statistic');
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function performanceTotalStatistic($model) {
		$serializer = PerformanceStatistic::getSerializer();
		$relationship = new Relationship(new Resource($model->getPerformanceTotalStatistic(), $serializer));
		$relationship->setLinks([
			'related' => '%apiurl%' . $serializer->getType(null) . '/' . $serializer->getId($model)
		]);
		return $this->addRelationshipSelfLink($relationship, $model, 'performance-total-statistic');
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function startgroups($model) {
		$relationship = new Relationship(new Collection($model->getStartgroups(), Startgroup::getSerializer()));
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

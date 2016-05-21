<?php
namespace iuf\junia\serializer\base;

use keeko\framework\utils\HydrateUtils;
use Tobscure\JsonApi\Relationship;
use iuf\junia\model\Competition;
use Tobscure\JsonApi\Resource;
use iuf\junia\model\Event;
use iuf\junia\model\PerformanceStatistic;
use iuf\junia\model\Routine;
use Tobscure\JsonApi\Collection;
use iuf\junia\model\Judge;

/**
 */
trait StartgroupSerializerTrait {

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function competition($model) {
		$serializer = Competition::getSerializer();
		$relationship = new Relationship(new Resource($model->getCompetition(), $serializer));
		$relationship->setLinks([
			'related' => '%apiurl%' . $serializer->getType(null) . '/' . $serializer->getId($model)
		]);
		return $this->addRelationshipSelfLink($relationship, $model, 'competition');
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function event($model) {
		$serializer = Event::getSerializer();
		$relationship = new Relationship(new Resource($model->getEvent(), $serializer));
		$relationship->setLinks([
			'related' => '%apiurl%' . $serializer->getType(null) . '/' . $serializer->getId($model)
		]);
		return $this->addRelationshipSelfLink($relationship, $model, 'event');
	}

	/**
	 * @param mixed $model
	 * @param array $fields
	 */
	public function getAttributes($model, array $fields = null) {
		return [
			'id' => $model->getId(),
			'name' => $model->getName(),
			'competition-id' => $model->getCompetitionId(),
			'event-id' => $model->getEventId(),
			'performance-total-statistic-id' => $model->getPerformanceTotalStatisticId(),
			'performance-execution-statistic-id' => $model->getPerformanceExecutionStatisticId(),
			'performance-choreography-statistic-id' => $model->getPerformanceChoreographyStatisticId(),
			'performance-music-and-timing-statistic-id' => $model->getPerformanceMusicAndTimingStatisticId(),
		];
	}

	/**
	 */
	public function getFields() {
		return ['id', 'name', 'competition-id', 'event-id', 'performance-total-statistic-id', 'performance-execution-statistic-id', 'performance-choreography-statistic-id', 'performance-music-and-timing-statistic-id'];
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
			'competition' => Competition::getSerializer()->getType(null),
			'event' => Event::getSerializer()->getType(null),
			'performance-total-statistic' => PerformanceStatistic::getSerializer()->getType(null),
			'performance-execution-statistic' => PerformanceStatistic::getSerializer()->getType(null),
			'performance-choreography-statistic' => PerformanceStatistic::getSerializer()->getType(null),
			'performance-music-and-timing-statistic' => PerformanceStatistic::getSerializer()->getType(null),
			'routines' => Routine::getSerializer()->getType(null),
			'judges' => Judge::getSerializer()->getType(null)
		];
	}

	/**
	 */
	public function getSortFields() {
		return ['id', 'name', 'competition-id', 'event-id', 'performance-total-statistic-id', 'performance-execution-statistic-id', 'performance-choreography-statistic-id', 'performance-music-and-timing-statistic-id'];
	}

	/**
	 * @param mixed $model
	 * @return string
	 */
	public function getType($model) {
		return 'iuf.junia/startgroup';
	}

	/**
	 * @param mixed $model
	 * @param mixed $data
	 * @return mixed The model
	 */
	public function hydrate($model, $data) {
		// attributes
		$attribs = isset($data['attributes']) ? $data['attributes'] : [];

		$model = HydrateUtils::hydrate($attribs, $model, ['id', 'name', 'competition-id', 'event-id', 'performance-total-statistic-id', 'performance-execution-statistic-id', 'performance-choreography-statistic-id', 'performance-music-and-timing-statistic-id']);

		// relationships
		$this->hydrateRelationships($model, $data);

		return $model;
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function judges($model) {
		$relationship = new Relationship(new Collection($model->getJudges(), Judge::getSerializer()));
		return $this->addRelationshipSelfLink($relationship, $model, 'judge');
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
	public function routines($model) {
		$relationship = new Relationship(new Collection($model->getRoutines(), Routine::getSerializer()));
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

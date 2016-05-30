<?php
namespace iuf\junia\serializer\base;

use iuf\junia\model\PerformanceScore;
use iuf\junia\model\PerformanceStatistic;
use iuf\junia\model\Startgroup;
use keeko\framework\utils\HydrateUtils;
use Tobscure\JsonApi\Collection;
use Tobscure\JsonApi\Relationship;
use Tobscure\JsonApi\Resource;

/**
 */
trait RoutineSerializerTrait {

	/**
	 * @param mixed $model
	 * @param array $fields
	 */
	public function getAttributes($model, array $fields = null) {
		return [
			'name' => $model->getName()
		];
	}

	/**
	 */
	public function getFields() {
		return ['name'];
	}

	/**
	 * @param mixed $model
	 * @return string
	 */
	public function getId($model) {
		if ($model !== null) {
			return $model->getId();
		}

		return null;
	}

	/**
	 */
	public function getRelationships() {
		return [
			'startgroup' => Startgroup::getSerializer()->getType(null),
			'performance-total-statistic' => PerformanceStatistic::getSerializer()->getType(null),
			'performance-execution-statistic' => PerformanceStatistic::getSerializer()->getType(null),
			'performance-choreography-statistic' => PerformanceStatistic::getSerializer()->getType(null),
			'performance-music-and-timing-statistic' => PerformanceStatistic::getSerializer()->getType(null),
			'performance-scores' => PerformanceScore::getSerializer()->getType(null)
		];
	}

	/**
	 */
	public function getSortFields() {
		return ['name'];
	}

	/**
	 * @param mixed $model
	 * @return string
	 */
	public function getType($model) {
		return 'iuf.junia/routine';
	}

	/**
	 * @param mixed $model
	 * @param mixed $data
	 * @return mixed The model
	 */
	public function hydrate($model, $data) {
		// attributes
		$attribs = isset($data['attributes']) ? $data['attributes'] : [];

		$model = HydrateUtils::hydrate($attribs, $model, ['id', 'name', 'startgroup-id', 'performance-total-statistic-id', 'performance-execution-statistic-id', 'performance-choreography-statistic-id', 'performance-music-and-timing-statistic-id']);

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
		$id = $serializer->getId($model->getPerformanceChoreographyStatistic());
		if ($id !== null) {
			$relationship = new Relationship(new Resource($model->getPerformanceChoreographyStatistic(), $serializer));
			$relationship->setLinks([
				'related' => '%apiurl%' . $serializer->getType(null) . '/' . $id 
			]);
			return $this->addRelationshipSelfLink($relationship, $model, 'performance-choreography-statistic');
		}

		return null;
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function performanceExecutionStatistic($model) {
		$serializer = PerformanceStatistic::getSerializer();
		$id = $serializer->getId($model->getPerformanceExecutionStatistic());
		if ($id !== null) {
			$relationship = new Relationship(new Resource($model->getPerformanceExecutionStatistic(), $serializer));
			$relationship->setLinks([
				'related' => '%apiurl%' . $serializer->getType(null) . '/' . $id 
			]);
			return $this->addRelationshipSelfLink($relationship, $model, 'performance-execution-statistic');
		}

		return null;
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function performanceMusicAndTimingStatistic($model) {
		$serializer = PerformanceStatistic::getSerializer();
		$id = $serializer->getId($model->getPerformanceMusicAndTimingStatistic());
		if ($id !== null) {
			$relationship = new Relationship(new Resource($model->getPerformanceMusicAndTimingStatistic(), $serializer));
			$relationship->setLinks([
				'related' => '%apiurl%' . $serializer->getType(null) . '/' . $id 
			]);
			return $this->addRelationshipSelfLink($relationship, $model, 'performance-music-and-timing-statistic');
		}

		return null;
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function performanceScores($model) {
		$relationship = new Relationship(new Collection($model->getPerformanceScores(), PerformanceScore::getSerializer()));
		return $this->addRelationshipSelfLink($relationship, $model, 'performance-score');
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function performanceTotalStatistic($model) {
		$serializer = PerformanceStatistic::getSerializer();
		$id = $serializer->getId($model->getPerformanceTotalStatistic());
		if ($id !== null) {
			$relationship = new Relationship(new Resource($model->getPerformanceTotalStatistic(), $serializer));
			$relationship->setLinks([
				'related' => '%apiurl%' . $serializer->getType(null) . '/' . $id 
			]);
			return $this->addRelationshipSelfLink($relationship, $model, 'performance-total-statistic');
		}

		return null;
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function startgroup($model) {
		$serializer = Startgroup::getSerializer();
		$id = $serializer->getId($model->getStartgroup());
		if ($id !== null) {
			$relationship = new Relationship(new Resource($model->getStartgroup(), $serializer));
			$relationship->setLinks([
				'related' => '%apiurl%' . $serializer->getType(null) . '/' . $id 
			]);
			return $this->addRelationshipSelfLink($relationship, $model, 'startgroup');
		}

		return null;
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

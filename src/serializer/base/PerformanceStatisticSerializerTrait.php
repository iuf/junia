<?php
namespace iuf\junia\serializer\base;

use iuf\junia\model\Event;
use iuf\junia\model\Routine;
use iuf\junia\model\Startgroup;
use keeko\framework\utils\HydrateUtils;
use Tobscure\JsonApi\Collection;
use Tobscure\JsonApi\Relationship;
use Tobscure\JsonApi\Resource;

/**
 */
trait PerformanceStatisticSerializerTrait {

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function events($model) {
		$relationship = new Relationship(new Collection($model->getEvents(), Event::getSerializer()));
		return $this->addRelationshipSelfLink($relationship, $model, 'event');
	}

	/**
	 * @param mixed $model
	 * @param array $fields
	 */
	public function getAttributes($model, array $fields = null) {
		return [
			'min' => $model->getMin(),
			'max' => $model->getMax(),
			'range' => $model->getRange(),
			'median' => $model->getMedian(),
			'average' => $model->getAverage(),
			'variance' => $model->getVariance(),
			'standard-deviation' => $model->getStandardDeviation(),
			'variability-coefficient' => $model->getVariabilityCoefficient()
		];
	}

	/**
	 */
	public function getFields() {
		return ['min', 'max', 'range', 'median', 'average', 'variance', 'standard-deviation', 'variability-coefficient'];
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
			'events' => Event::getSerializer()->getType(null),
			'startgroups' => Startgroup::getSerializer()->getType(null),
			'routine' => Routine::getSerializer()->getType(null)
		];
	}

	/**
	 */
	public function getSortFields() {
		return ['min', 'max', 'range', 'median', 'average', 'variance', 'standard-deviation', 'variability-coefficient'];
	}

	/**
	 * @param mixed $model
	 * @return string
	 */
	public function getType($model) {
		return 'iuf.junia/performance-statistic';
	}

	/**
	 * @param mixed $model
	 * @param mixed $data
	 * @return mixed The model
	 */
	public function hydrate($model, $data) {
		// attributes
		$attribs = isset($data['attributes']) ? $data['attributes'] : [];

		$model = HydrateUtils::hydrate($attribs, $model, ['id', 'min', 'max', 'range', 'median', 'average', 'variance', 'standard-deviation', 'variability-coefficient']);

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
		$id = $serializer->getId($model->getRoutine());
		if ($id !== null) {
			$relationship = new Relationship(new Resource($model->getRoutine(), $serializer));
			$relationship->setLinks([
				'related' => '%apiurl%' . $serializer->getType(null) . '/' . $id 
			]);
			return $this->addRelationshipSelfLink($relationship, $model, 'routine');
		}

		return null;
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

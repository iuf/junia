<?php
namespace iuf\junia\serializer\base;

use keeko\framework\utils\HydrateUtils;
use Tobscure\JsonApi\Relationship;
use iuf\junia\model\Competition;
use Tobscure\JsonApi\Resource;
use iuf\junia\model\iuf\junia\model\Event;

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
			'competition_id' => $model->getCompetitionId(),
			'event_id' => $model->getEventId(),
		];
	}

	/**
	 */
	public function getFields() {
		return ['id', 'name', 'competition_id', 'event_id'];
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
			'event' => Event::getSerializer()->getType(null)
		];
	}

	/**
	 */
	public function getSortFields() {
		return ['id', 'name', 'competition_id', 'event_id'];
	}

	/**
	 * @param mixed $model
	 * @return string
	 */
	public function getType($model) {
		return 'junia/startgroup';
	}

	/**
	 * @param mixed $model
	 * @param mixed $data
	 * @return mixed The model
	 */
	public function hydrate($model, $data) {
		// attributes
		$attribs = isset($data['attributes']) ? $data['attributes'] : [];

		$model = HydrateUtils::hydrate($attribs, $model, ['id', 'name', 'competition_id', 'event_id']);

		// relationships
		$this->hydrateRelationships($model, $data);

		return $model;
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
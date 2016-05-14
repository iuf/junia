<?php
namespace iuf\junia\serializer\base;

use keeko\framework\utils\HydrateUtils;
use Tobscure\JsonApi\Relationship;
use iuf\junia\model\Routine;
use Tobscure\JsonApi\Resource;
use iuf\junia\model\Judge;

/**
 */
trait ScoreSerializerTrait {

	/**
	 * @param mixed $model
	 * @param array $fields
	 */
	public function getAttributes($model, array $fields = null) {
		return [
			'id' => $model->getId(),
			'routine_id' => $model->getRoutineId(),
			'judge_id' => $model->getJudgeId(),
			'total' => $model->getTotal(),
			'descendant_class' => $model->getDescendantClass(),
		];
	}

	/**
	 */
	public function getFields() {
		return ['id', 'routine_id', 'judge_id', 'total', 'descendant_class'];
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
			'routine' => Routine::getSerializer()->getType(null),
			'judge' => Judge::getSerializer()->getType(null)
		];
	}

	/**
	 */
	public function getSortFields() {
		return ['id', 'routine_id', 'judge_id', 'total', 'descendant_class'];
	}

	/**
	 * @param mixed $model
	 * @return string
	 */
	public function getType($model) {
		return 'junia/score';
	}

	/**
	 * @param mixed $model
	 * @param mixed $data
	 * @return mixed The model
	 */
	public function hydrate($model, $data) {
		// attributes
		$attribs = isset($data['attributes']) ? $data['attributes'] : [];

		$model = HydrateUtils::hydrate($attribs, $model, ['id', 'routine_id', 'judge_id', 'total', 'descendant_class']);

		// relationships
		$this->hydrateRelationships($model, $data);

		return $model;
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function judge($model) {
		$serializer = Judge::getSerializer();
		$relationship = new Relationship(new Resource($model->getJudge(), $serializer));
		$relationship->setLinks([
			'related' => '%apiurl%' . $serializer->getType(null) . '/' . $serializer->getId($model)
		]);
		return $this->addRelationshipSelfLink($relationship, $model, 'judge');
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

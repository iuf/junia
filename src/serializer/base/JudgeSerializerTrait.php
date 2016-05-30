<?php
namespace iuf\junia\serializer\base;

use iuf\junia\model\PerformanceScore;
use iuf\junia\model\Startgroup;
use keeko\core\model\User;
use keeko\framework\utils\HydrateUtils;
use Tobscure\JsonApi\Relationship;
use Tobscure\JsonApi\Resource;

/**
 */
trait JudgeSerializerTrait {

	/**
	 * @param mixed $model
	 * @param array $fields
	 */
	public function getAttributes($model, array $fields = null) {
		return [
			'position' => $model->getPosition()
		];
	}

	/**
	 */
	public function getFields() {
		return ['position'];
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
			'user' => User::getSerializer()->getType(null),
			'performance-score' => PerformanceScore::getSerializer()->getType(null)
		];
	}

	/**
	 */
	public function getSortFields() {
		return ['position'];
	}

	/**
	 * @param mixed $model
	 * @return string
	 */
	public function getType($model) {
		return 'iuf.junia/judge';
	}

	/**
	 * @param mixed $model
	 * @param mixed $data
	 * @return mixed The model
	 */
	public function hydrate($model, $data) {
		// attributes
		$attribs = isset($data['attributes']) ? $data['attributes'] : [];

		$model = HydrateUtils::hydrate($attribs, $model, ['id', 'position', 'startgroup-id', 'user-id']);

		// relationships
		$this->hydrateRelationships($model, $data);

		return $model;
	}

	/**
	 * @param mixed $model
	 * @return Relationship
	 */
	public function performanceScore($model) {
		$serializer = PerformanceScore::getSerializer();
		$id = $serializer->getId($model->getPerformanceScore());
		if ($id !== null) {
			$relationship = new Relationship(new Resource($model->getPerformanceScore(), $serializer));
			$relationship->setLinks([
				'related' => '%apiurl%' . $serializer->getType(null) . '/' . $id 
			]);
			return $this->addRelationshipSelfLink($relationship, $model, 'performance-score');
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
	 * @param mixed $model
	 * @return Relationship
	 */
	public function user($model) {
		$serializer = User::getSerializer();
		$id = $serializer->getId($model->getUser());
		if ($id !== null) {
			$relationship = new Relationship(new Resource($model->getUser(), $serializer));
			$relationship->setLinks([
				'related' => '%apiurl%' . $serializer->getType(null) . '/' . $id 
			]);
			return $this->addRelationshipSelfLink($relationship, $model, 'user');
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

<?php
namespace iuf\junia\serializer\base;

use iuf\junia\model\Startgroup;
use keeko\framework\utils\HydrateUtils;
use Tobscure\JsonApi\Collection;
use Tobscure\JsonApi\Relationship;

/**
 */
trait CompetitionSerializerTrait {

	/**
	 * @param mixed $model
	 * @param array $fields
	 */
	public function getAttributes($model, array $fields = null) {
		return [
			'label' => $model->getLabel(),
			'slug' => $model->getSlug()
		];
	}

	/**
	 */
	public function getFields() {
		return ['label', 'slug'];
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
			'startgroups' => Startgroup::getSerializer()->getType(null)
		];
	}

	/**
	 */
	public function getSortFields() {
		return ['label', 'slug'];
	}

	/**
	 * @param mixed $model
	 * @return string
	 */
	public function getType($model) {
		return 'iuf.junia/competition';
	}

	/**
	 * @param mixed $model
	 * @param mixed $data
	 * @return mixed The model
	 */
	public function hydrate($model, $data) {
		// attributes
		$attribs = isset($data['attributes']) ? $data['attributes'] : [];

		$model = HydrateUtils::hydrate($attribs, $model, ['id', 'label', 'slug']);

		// relationships
		$this->hydrateRelationships($model, $data);

		return $model;
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

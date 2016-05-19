<?php
namespace iuf\junia\domain\base;

use iuf\junia\model\Competition;
use iuf\junia\model\CompetitionQuery;
use keeko\framework\service\ServiceContainer;
use keeko\framework\domain\payload\PayloadInterface;
use phootwork\collection\Map;
use keeko\framework\domain\payload\Found;
use keeko\framework\domain\payload\NotFound;
use keeko\framework\utils\Parameters;
use keeko\framework\utils\NameUtils;
use iuf\junia\event\CompetitionEvent;
use keeko\framework\domain\payload\Created;
use keeko\framework\domain\payload\NotValid;
use keeko\framework\domain\payload\Updated;
use keeko\framework\domain\payload\NotUpdated;
use keeko\framework\domain\payload\Deleted;
use keeko\framework\domain\payload\NotDeleted;
use iuf\junia\model\StartgroupQuery;

/**
 */
trait CompetitionDomainTrait {

	/**
	 */
	protected $pool;

	/**
	 * Adds Startgroups to Competition
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function addStartgroups($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Competition not found.']);
		}
		 
		// update
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Startgroup';
			}
			$related = StartgroupQuery::create()->findOneById($entry['id']);
			$model->addStartgroup($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new CompetitionEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(CompetitionEvent::PRE_STARTGROUPS_ADD, $event);
		$dispatcher->dispatch(CompetitionEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(CompetitionEvent::POST_STARTGROUPS_ADD, $event);
		$dispatcher->dispatch(CompetitionEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Creates a new Competition with the provided data
	 * 
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function create($data) {
		// hydrate
		$serializer = Competition::getSerializer();
		$model = $serializer->hydrate(new Competition(), $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($model)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new CompetitionEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(CompetitionEvent::PRE_CREATE, $event);
		$dispatcher->dispatch(CompetitionEvent::PRE_SAVE, $event);
		$model->save();
		$dispatcher->dispatch(CompetitionEvent::POST_CREATE, $event);
		$dispatcher->dispatch(CompetitionEvent::POST_SAVE, $event);
		return new Created(['model' => $model]);
	}

	/**
	 * Deletes a Competition with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function delete($id) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Competition not found.']);
		}

		// delete
		$event = new CompetitionEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(CompetitionEvent::PRE_DELETE, $event);
		$model->delete();

		if ($model->isDeleted()) {
			$dispatcher->dispatch(CompetitionEvent::POST_DELETE, $event);
			return new Deleted(['model' => $model]);
		}

		return new NotDeleted(['message' => 'Could not delete Competition']);
	}

	/**
	 * Returns a paginated result
	 * 
	 * @param Parameters $params
	 * @return PayloadInterface
	 */
	public function paginate(Parameters $params) {
		$sysPrefs = $this->getServiceContainer()->getPreferenceLoader()->getSystemPreferences();
		$defaultSize = $sysPrefs->getPaginationSize();
		$page = $params->getPage('number');
		$size = $params->getPage('size', $defaultSize);

		$query = CompetitionQuery::create();

		// sorting
		$sort = $params->getSort(Competition::getSerializer()->getSortFields());
		foreach ($sort as $field => $order) {
			$method = 'orderBy' . NameUtils::toStudlyCase($field);
			$query->$method($order);
		}

		// filtering
		$filter = $params->getFilter();
		if (!empty($filter)) {
			$this->applyFilter($query, $filter);
		}

		// paginate
		$model = $query->paginate($page, $size);

		// run response
		return new Found(['model' => $model]);
	}

	/**
	 * Returns one Competition with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function read($id) {
		// read
		$model = $this->get($id);

		// check existence
		if ($model === null) {
			return new NotFound(['message' => 'Competition not found.']);
		}

		return new Found(['model' => $model]);
	}

	/**
	 * Removes Startgroups from Competition
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function removeStartgroups($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Competition not found.']);
		}

		// remove them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Startgroup';
			}
			$related = StartgroupQuery::create()->findOneById($entry['id']);
			$model->removeStartgroup($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new CompetitionEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(CompetitionEvent::PRE_STARTGROUPS_REMOVE, $event);
		$dispatcher->dispatch(CompetitionEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(CompetitionEvent::POST_STARTGROUPS_REMOVE, $event);
		$dispatcher->dispatch(CompetitionEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Updates a Competition with the given idand the provided data
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function update($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Competition not found.']);
		}

		// hydrate
		$serializer = Competition::getSerializer();
		$model = $serializer->hydrate($model, $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($model)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new CompetitionEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(CompetitionEvent::PRE_UPDATE, $event);
		$dispatcher->dispatch(CompetitionEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(CompetitionEvent::POST_UPDATE, $event);
		$dispatcher->dispatch(CompetitionEvent::POST_SAVE, $event);

		$payload = ['model' => $model];

		if ($rows === 0) {
			return new NotUpdated($payload);
		}

		return new Updated($payload);
	}

	/**
	 * Updates Startgroups on Competition
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function updateStartgroups($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Competition not found.']);
		}

		// remove all relationships before
		StartgroupQuery::create()->filterByCompetition($model)->delete();

		// add them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Startgroup';
			}
			$related = StartgroupQuery::create()->findOneById($entry['id']);
			$model->addStartgroup($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new CompetitionEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(CompetitionEvent::PRE_STARTGROUPS_UPDATE, $event);
		$dispatcher->dispatch(CompetitionEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(CompetitionEvent::POST_STARTGROUPS_UPDATE, $event);
		$dispatcher->dispatch(CompetitionEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Implement this functionality at iuf\junia\domain\CompetitionDomain
	 * 
	 * @param CompetitionQuery $query
	 * @param mixed $filter
	 * @return void
	 */
	abstract protected function applyFilter(CompetitionQuery $query, $filter);

	/**
	 * Returns one Competition with the given id from cache
	 * 
	 * @param mixed $id
	 * @return Competition|null
	 */
	protected function get($id) {
		if ($this->pool === null) {
			$this->pool = new Map();
		} else if ($this->pool->has($id)) {
			return $this->pool->get($id);
		}

		$model = CompetitionQuery::create()->findOneById($id);
		$this->pool->set($id, $model);

		return $model;
	}

	/**
	 * Returns the service container
	 * 
	 * @return ServiceContainer
	 */
	abstract protected function getServiceContainer();
}

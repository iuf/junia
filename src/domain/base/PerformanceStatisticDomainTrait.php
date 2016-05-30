<?php
namespace iuf\junia\domain\base;

use iuf\junia\event\PerformanceStatisticEvent;
use iuf\junia\model\EventQuery;
use iuf\junia\model\PerformanceStatisticQuery;
use iuf\junia\model\PerformanceStatistic;
use iuf\junia\model\StartgroupQuery;
use keeko\framework\domain\payload\Created;
use keeko\framework\domain\payload\Deleted;
use keeko\framework\domain\payload\Found;
use keeko\framework\domain\payload\NotDeleted;
use keeko\framework\domain\payload\NotFound;
use keeko\framework\domain\payload\NotUpdated;
use keeko\framework\domain\payload\NotValid;
use keeko\framework\domain\payload\PayloadInterface;
use keeko\framework\domain\payload\Updated;
use keeko\framework\service\ServiceContainer;
use keeko\framework\utils\NameUtils;
use keeko\framework\utils\Parameters;
use phootwork\collection\Map;

/**
 */
trait PerformanceStatisticDomainTrait {

	/**
	 */
	protected $pool;

	/**
	 * Adds Events to PerformanceStatistic
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function addEvents($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'PerformanceStatistic not found.']);
		}
		 
		// update
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Event';
			}
			$related = EventQuery::create()->findOneById($entry['id']);
			$model->addEvent($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new PerformanceStatisticEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_EVENTS_ADD, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_EVENTS_ADD, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Adds Startgroups to PerformanceStatistic
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function addStartgroups($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'PerformanceStatistic not found.']);
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
		$event = new PerformanceStatisticEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_STARTGROUPS_ADD, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_STARTGROUPS_ADD, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Creates a new PerformanceStatistic with the provided data
	 * 
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function create($data) {
		// hydrate
		$serializer = PerformanceStatistic::getSerializer();
		$model = $serializer->hydrate(new PerformanceStatistic(), $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($model)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new PerformanceStatisticEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_CREATE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_SAVE, $event);
		$model->save();
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_CREATE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_SAVE, $event);
		return new Created(['model' => $model]);
	}

	/**
	 * Deletes a PerformanceStatistic with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function delete($id) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'PerformanceStatistic not found.']);
		}

		// delete
		$event = new PerformanceStatisticEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_DELETE, $event);
		$model->delete();

		if ($model->isDeleted()) {
			$dispatcher->dispatch(PerformanceStatisticEvent::POST_DELETE, $event);
			return new Deleted(['model' => $model]);
		}

		return new NotDeleted(['message' => 'Could not delete PerformanceStatistic']);
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

		$query = PerformanceStatisticQuery::create();

		// sorting
		$sort = $params->getSort(PerformanceStatistic::getSerializer()->getSortFields());
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
	 * Returns one PerformanceStatistic with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function read($id) {
		// read
		$model = $this->get($id);

		// check existence
		if ($model === null) {
			return new NotFound(['message' => 'PerformanceStatistic not found.']);
		}

		return new Found(['model' => $model]);
	}

	/**
	 * Removes Events from PerformanceStatistic
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function removeEvents($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'PerformanceStatistic not found.']);
		}

		// remove them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Event';
			}
			$related = EventQuery::create()->findOneById($entry['id']);
			$model->removeEvent($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new PerformanceStatisticEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_EVENTS_REMOVE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_EVENTS_REMOVE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Removes Startgroups from PerformanceStatistic
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function removeStartgroups($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'PerformanceStatistic not found.']);
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
		$event = new PerformanceStatisticEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_STARTGROUPS_REMOVE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_STARTGROUPS_REMOVE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Sets the Routine id
	 * 
	 * @param mixed $id
	 * @param mixed $relatedId
	 * @return PayloadInterface
	 */
	public function setRoutineId($id, $relatedId) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'PerformanceStatistic not found.']);
		}

		// update
		if ($model->getPerformanceMusicAndTimingStatisticId() !== $relatedId) {
			$model->setPerformanceMusicAndTimingStatisticId($relatedId);

			$event = new PerformanceStatisticEvent($model);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(PerformanceStatisticEvent::PRE_ROUTINE_UPDATE, $event);
			$dispatcher->dispatch(PerformanceStatisticEvent::PRE_SAVE, $event);
			$model->save();
			$dispatcher->dispatch(PerformanceStatisticEvent::POST_ROUTINE_UPDATE, $event);
			$dispatcher->dispatch(PerformanceStatisticEvent::POST_SAVE, $event);
			
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Updates a PerformanceStatistic with the given idand the provided data
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function update($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'PerformanceStatistic not found.']);
		}

		// hydrate
		$serializer = PerformanceStatistic::getSerializer();
		$model = $serializer->hydrate($model, $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($model)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new PerformanceStatisticEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_UPDATE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_UPDATE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_SAVE, $event);

		$payload = ['model' => $model];

		if ($rows === 0) {
			return new NotUpdated($payload);
		}

		return new Updated($payload);
	}

	/**
	 * Updates Events on PerformanceStatistic
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function updateEvents($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'PerformanceStatistic not found.']);
		}

		// remove all relationships before
		EventQuery::create()->filterByPerformanceMusicAndTimingStatistic($model)->delete();

		// add them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Event';
			}
			$related = EventQuery::create()->findOneById($entry['id']);
			$model->addEvent($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new PerformanceStatisticEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_EVENTS_UPDATE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_EVENTS_UPDATE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Updates Startgroups on PerformanceStatistic
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function updateStartgroups($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'PerformanceStatistic not found.']);
		}

		// remove all relationships before
		StartgroupQuery::create()->filterByPerformanceMusicAndTimingStatistic($model)->delete();

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
		$event = new PerformanceStatisticEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_STARTGROUPS_UPDATE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_STARTGROUPS_UPDATE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * @param mixed $query
	 * @param mixed $filter
	 * @return void
	 */
	protected function applyFilter($query, $filter) {
		foreach ($filter as $column => $value) {
			$pos = strpos($column, '.');
			if ($pos !== false) {
				$rel = NameUtils::toStudlyCase(substr($column, 0, $pos));
				$col = substr($column, $pos + 1);
				$method = 'use' . $rel . 'Query';
				if (method_exists($query, $method)) {
					$sub = $query->$method();
					$this->applyFilter($sub, [$col => $value]);
					$sub->endUse();
				}
			} else {
				$method = 'filterBy' . NameUtils::toStudlyCase($column);
				if (method_exists($query, $method)) {
					$query->$method($value);
				}
			}
		}
	}

	/**
	 * Returns one PerformanceStatistic with the given id from cache
	 * 
	 * @param mixed $id
	 * @return PerformanceStatistic|null
	 */
	protected function get($id) {
		if ($this->pool === null) {
			$this->pool = new Map();
		} else if ($this->pool->has($id)) {
			return $this->pool->get($id);
		}

		$model = PerformanceStatisticQuery::create()->findOneById($id);
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

<?php
namespace iuf\junia\domain\base;

use iuf\junia\event\StartgroupEvent;
use iuf\junia\model\JudgeQuery;
use iuf\junia\model\RoutineQuery;
use iuf\junia\model\StartgroupQuery;
use iuf\junia\model\Startgroup;
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
trait StartgroupDomainTrait {

	/**
	 */
	protected $pool;

	/**
	 * Adds Judges to Startgroup
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function addJudges($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}
		 
		// update
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Judge';
			}
			$related = JudgeQuery::create()->findOneById($entry['id']);
			$model->addJudge($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new StartgroupEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(StartgroupEvent::PRE_JUDGES_ADD, $event);
		$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(StartgroupEvent::POST_JUDGES_ADD, $event);
		$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Adds Routines to Startgroup
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function addRoutines($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}
		 
		// update
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Routine';
			}
			$related = RoutineQuery::create()->findOneById($entry['id']);
			$model->addRoutine($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new StartgroupEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(StartgroupEvent::PRE_ROUTINES_ADD, $event);
		$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(StartgroupEvent::POST_ROUTINES_ADD, $event);
		$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Creates a new Startgroup with the provided data
	 * 
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function create($data) {
		// hydrate
		$serializer = Startgroup::getSerializer();
		$model = $serializer->hydrate(new Startgroup(), $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($model)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new StartgroupEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(StartgroupEvent::PRE_CREATE, $event);
		$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
		$model->save();
		$dispatcher->dispatch(StartgroupEvent::POST_CREATE, $event);
		$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);
		return new Created(['model' => $model]);
	}

	/**
	 * Deletes a Startgroup with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function delete($id) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// delete
		$event = new StartgroupEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(StartgroupEvent::PRE_DELETE, $event);
		$model->delete();

		if ($model->isDeleted()) {
			$dispatcher->dispatch(StartgroupEvent::POST_DELETE, $event);
			return new Deleted(['model' => $model]);
		}

		return new NotDeleted(['message' => 'Could not delete Startgroup']);
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

		$query = StartgroupQuery::create();

		// sorting
		$sort = $params->getSort(Startgroup::getSerializer()->getSortFields());
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
	 * Returns one Startgroup with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function read($id) {
		// read
		$model = $this->get($id);

		// check existence
		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		return new Found(['model' => $model]);
	}

	/**
	 * Removes Judges from Startgroup
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function removeJudges($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// remove them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Judge';
			}
			$related = JudgeQuery::create()->findOneById($entry['id']);
			$model->removeJudge($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new StartgroupEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(StartgroupEvent::PRE_JUDGES_REMOVE, $event);
		$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(StartgroupEvent::POST_JUDGES_REMOVE, $event);
		$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Removes Routines from Startgroup
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function removeRoutines($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// remove them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Routine';
			}
			$related = RoutineQuery::create()->findOneById($entry['id']);
			$model->removeRoutine($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new StartgroupEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(StartgroupEvent::PRE_ROUTINES_REMOVE, $event);
		$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(StartgroupEvent::POST_ROUTINES_REMOVE, $event);
		$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Sets the Competition id
	 * 
	 * @param mixed $id
	 * @param mixed $relatedId
	 * @return PayloadInterface
	 */
	public function setCompetitionId($id, $relatedId) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// update
		if ($model->getCompetitionId() !== $relatedId) {
			$model->setCompetitionId($relatedId);

			$event = new StartgroupEvent($model);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(StartgroupEvent::PRE_COMPETITION_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
			$model->save();
			$dispatcher->dispatch(StartgroupEvent::POST_COMPETITION_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);
			
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Sets the Event id
	 * 
	 * @param mixed $id
	 * @param mixed $relatedId
	 * @return PayloadInterface
	 */
	public function setEventId($id, $relatedId) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// update
		if ($model->getEventId() !== $relatedId) {
			$model->setEventId($relatedId);

			$event = new StartgroupEvent($model);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(StartgroupEvent::PRE_EVENT_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
			$model->save();
			$dispatcher->dispatch(StartgroupEvent::POST_EVENT_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);
			
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Sets the PerformanceChoreographyStatistic id
	 * 
	 * @param mixed $id
	 * @param mixed $relatedId
	 * @return PayloadInterface
	 */
	public function setPerformanceChoreographyStatisticId($id, $relatedId) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// update
		if ($model->getPerformanceChoreographyStatisticId() !== $relatedId) {
			$model->setPerformanceChoreographyStatisticId($relatedId);

			$event = new StartgroupEvent($model);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(StartgroupEvent::PRE_PERFORMANCE_CHOREOGRAPHY_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
			$model->save();
			$dispatcher->dispatch(StartgroupEvent::POST_PERFORMANCE_CHOREOGRAPHY_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);
			
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Sets the PerformanceExecutionStatistic id
	 * 
	 * @param mixed $id
	 * @param mixed $relatedId
	 * @return PayloadInterface
	 */
	public function setPerformanceExecutionStatisticId($id, $relatedId) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// update
		if ($model->getPerformanceExecutionStatisticId() !== $relatedId) {
			$model->setPerformanceExecutionStatisticId($relatedId);

			$event = new StartgroupEvent($model);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(StartgroupEvent::PRE_PERFORMANCE_EXECUTION_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
			$model->save();
			$dispatcher->dispatch(StartgroupEvent::POST_PERFORMANCE_EXECUTION_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);
			
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Sets the PerformanceMusicAndTimingStatistic id
	 * 
	 * @param mixed $id
	 * @param mixed $relatedId
	 * @return PayloadInterface
	 */
	public function setPerformanceMusicAndTimingStatisticId($id, $relatedId) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// update
		if ($model->getPerformanceMusicAndTimingStatisticId() !== $relatedId) {
			$model->setPerformanceMusicAndTimingStatisticId($relatedId);

			$event = new StartgroupEvent($model);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(StartgroupEvent::PRE_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
			$model->save();
			$dispatcher->dispatch(StartgroupEvent::POST_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);
			
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Sets the PerformanceTotalStatistic id
	 * 
	 * @param mixed $id
	 * @param mixed $relatedId
	 * @return PayloadInterface
	 */
	public function setPerformanceTotalStatisticId($id, $relatedId) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// update
		if ($model->getPerformanceTotalStatisticId() !== $relatedId) {
			$model->setPerformanceTotalStatisticId($relatedId);

			$event = new StartgroupEvent($model);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(StartgroupEvent::PRE_PERFORMANCE_TOTAL_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
			$model->save();
			$dispatcher->dispatch(StartgroupEvent::POST_PERFORMANCE_TOTAL_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);
			
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Updates a Startgroup with the given idand the provided data
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function update($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// hydrate
		$serializer = Startgroup::getSerializer();
		$model = $serializer->hydrate($model, $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($model)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new StartgroupEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(StartgroupEvent::PRE_UPDATE, $event);
		$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(StartgroupEvent::POST_UPDATE, $event);
		$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);

		$payload = ['model' => $model];

		if ($rows === 0) {
			return new NotUpdated($payload);
		}

		return new Updated($payload);
	}

	/**
	 * Updates Judges on Startgroup
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function updateJudges($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// remove all relationships before
		JudgeQuery::create()->filterByStartgroup($model)->delete();

		// add them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Judge';
			}
			$related = JudgeQuery::create()->findOneById($entry['id']);
			$model->addJudge($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new StartgroupEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(StartgroupEvent::PRE_JUDGES_UPDATE, $event);
		$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(StartgroupEvent::POST_JUDGES_UPDATE, $event);
		$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Updates Routines on Startgroup
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function updateRoutines($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// remove all relationships before
		RoutineQuery::create()->filterByStartgroup($model)->delete();

		// add them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Routine';
			}
			$related = RoutineQuery::create()->findOneById($entry['id']);
			$model->addRoutine($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new StartgroupEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(StartgroupEvent::PRE_ROUTINES_UPDATE, $event);
		$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(StartgroupEvent::POST_ROUTINES_UPDATE, $event);
		$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);

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
	 * Returns one Startgroup with the given id from cache
	 * 
	 * @param mixed $id
	 * @return Startgroup|null
	 */
	protected function get($id) {
		if ($this->pool === null) {
			$this->pool = new Map();
		} else if ($this->pool->has($id)) {
			return $this->pool->get($id);
		}

		$model = StartgroupQuery::create()->findOneById($id);
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

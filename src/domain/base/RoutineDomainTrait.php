<?php
namespace iuf\junia\domain\base;

use iuf\junia\model\Routine;
use iuf\junia\model\RoutineQuery;
use keeko\framework\service\ServiceContainer;
use keeko\framework\domain\payload\PayloadInterface;
use phootwork\collection\Map;
use keeko\framework\domain\payload\Found;
use keeko\framework\domain\payload\NotFound;
use keeko\framework\utils\Parameters;
use keeko\framework\utils\NameUtils;
use iuf\junia\event\RoutineEvent;
use keeko\framework\domain\payload\Created;
use keeko\framework\domain\payload\NotValid;
use keeko\framework\domain\payload\Updated;
use keeko\framework\domain\payload\NotUpdated;
use keeko\framework\domain\payload\Deleted;
use keeko\framework\domain\payload\NotDeleted;
use iuf\junia\model\PerformanceScoreQuery;

/**
 */
trait RoutineDomainTrait {

	/**
	 */
	protected $pool;

	/**
	 * Adds PerformanceScores to Routine
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function addPerformanceScores($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}
		 
		// update
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for PerformanceScore';
			}
			$related = PerformanceScoreQuery::create()->findOneById($entry['id']);
			$model->addPerformanceScore($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new RoutineEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_SCORES_ADD, $event);
		$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_SCORES_ADD, $event);
		$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Creates a new Routine with the provided data
	 * 
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function create($data) {
		// hydrate
		$serializer = Routine::getSerializer();
		$model = $serializer->hydrate(new Routine(), $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($model)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new RoutineEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(RoutineEvent::PRE_CREATE, $event);
		$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
		$model->save();
		$dispatcher->dispatch(RoutineEvent::POST_CREATE, $event);
		$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);
		return new Created(['model' => $model]);
	}

	/**
	 * Deletes a Routine with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function delete($id) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// delete
		$event = new RoutineEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(RoutineEvent::PRE_DELETE, $event);
		$model->delete();

		if ($model->isDeleted()) {
			$dispatcher->dispatch(RoutineEvent::POST_DELETE, $event);
			return new Deleted(['model' => $model]);
		}

		return new NotDeleted(['message' => 'Could not delete Routine']);
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

		$query = RoutineQuery::create();

		// sorting
		$sort = $params->getSort(Routine::getSerializer()->getSortFields());
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
	 * Returns one Routine with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function read($id) {
		// read
		$model = $this->get($id);

		// check existence
		if ($model === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		return new Found(['model' => $model]);
	}

	/**
	 * Removes PerformanceScores from Routine
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function removePerformanceScores($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// remove them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for PerformanceScore';
			}
			$related = PerformanceScoreQuery::create()->findOneById($entry['id']);
			$model->removePerformanceScore($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new RoutineEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_SCORES_REMOVE, $event);
		$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_SCORES_REMOVE, $event);
		$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);

		if ($rows > 0) {
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
			return new NotFound(['message' => 'Routine not found.']);
		}

		// update
		if ($model->getPerformanceChoreographyStatisticId() !== $relatedId) {
			$model->setPerformanceChoreographyStatisticId($relatedId);

			$event = new RoutineEvent($model);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_CHOREOGRAPHY_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
			$model->save();
			$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_CHOREOGRAPHY_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);
			
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
			return new NotFound(['message' => 'Routine not found.']);
		}

		// update
		if ($model->getPerformanceExecutionStatisticId() !== $relatedId) {
			$model->setPerformanceExecutionStatisticId($relatedId);

			$event = new RoutineEvent($model);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_EXECUTION_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
			$model->save();
			$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_EXECUTION_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);
			
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
			return new NotFound(['message' => 'Routine not found.']);
		}

		// update
		if ($model->getPerformanceMusicAndTimingStatisticId() !== $relatedId) {
			$model->setPerformanceMusicAndTimingStatisticId($relatedId);

			$event = new RoutineEvent($model);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
			$model->save();
			$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);
			
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
			return new NotFound(['message' => 'Routine not found.']);
		}

		// update
		if ($model->getPerformanceTotalStatisticId() !== $relatedId) {
			$model->setPerformanceTotalStatisticId($relatedId);

			$event = new RoutineEvent($model);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_TOTAL_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
			$model->save();
			$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_TOTAL_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);
			
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Sets the Startgroup id
	 * 
	 * @param mixed $id
	 * @param mixed $relatedId
	 * @return PayloadInterface
	 */
	public function setStartgroupId($id, $relatedId) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// update
		if ($model->getStartgroupId() !== $relatedId) {
			$model->setStartgroupId($relatedId);

			$event = new RoutineEvent($model);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(RoutineEvent::PRE_STARTGROUP_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
			$model->save();
			$dispatcher->dispatch(RoutineEvent::POST_STARTGROUP_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);
			
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
	}

	/**
	 * Updates a Routine with the given idand the provided data
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function update($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// hydrate
		$serializer = Routine::getSerializer();
		$model = $serializer->hydrate($model, $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($model)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new RoutineEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(RoutineEvent::PRE_UPDATE, $event);
		$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(RoutineEvent::POST_UPDATE, $event);
		$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);

		$payload = ['model' => $model];

		if ($rows === 0) {
			return new NotUpdated($payload);
		}

		return new Updated($payload);
	}

	/**
	 * Updates PerformanceScores on Routine
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function updatePerformanceScores($id, $data) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// remove all relationships before
		PerformanceScoreQuery::create()->filterByRoutine($model)->delete();

		// add them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for PerformanceScore';
			}
			$related = PerformanceScoreQuery::create()->findOneById($entry['id']);
			$model->addPerformanceScore($related);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new RoutineEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_SCORES_UPDATE, $event);
		$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_SCORES_UPDATE, $event);
		$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);

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
	 * Returns one Routine with the given id from cache
	 * 
	 * @param mixed $id
	 * @return Routine|null
	 */
	protected function get($id) {
		if ($this->pool === null) {
			$this->pool = new Map();
		} else if ($this->pool->has($id)) {
			return $this->pool->get($id);
		}

		$model = RoutineQuery::create()->findOneById($id);
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

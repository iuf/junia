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
		$routine = $this->get($id);

		if ($routine === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}
		 
		// update
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for PerformanceScore';
			}
			$performanceScore = PerformanceScoreQuery::create()->findOneById($entry['id']);
			$routine->addPerformanceScore($performanceScore);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new RoutineEvent($routine);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_SCORES_ADD, $event);
		$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
		$rows = $routine->save();
		$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_SCORES_ADD, $event);
		$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $routine]);
		}

		return NotUpdated(['model' => $routine]);
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
		$routine = $serializer->hydrate(new Routine(), $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($routine)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new RoutineEvent($routine);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(RoutineEvent::PRE_CREATE, $event);
		$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
		$routine->save();
		$dispatcher->dispatch(RoutineEvent::POST_CREATE, $event);
		$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);
		return new Created(['model' => $routine]);
	}

	/**
	 * Deletes a Routine with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function delete($id) {
		// find
		$routine = $this->get($id);

		if ($routine === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// delete
		$event = new RoutineEvent($routine);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(RoutineEvent::PRE_DELETE, $event);
		$routine->delete();

		if ($routine->isDeleted()) {
			$dispatcher->dispatch(RoutineEvent::POST_DELETE, $event);
			return new Deleted(['model' => $routine]);
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
		$routine = $query->paginate($page, $size);

		// run response
		return new Found(['model' => $routine]);
	}

	/**
	 * Returns one Routine with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function read($id) {
		// read
		$routine = $this->get($id);

		// check existence
		if ($routine === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		return new Found(['model' => $routine]);
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
		$routine = $this->get($id);

		if ($routine === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// remove them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for PerformanceScore';
			}
			$performanceScore = PerformanceScoreQuery::create()->findOneById($entry['id']);
			$routine->removePerformanceScore($performanceScore);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new RoutineEvent($routine);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_SCORES_REMOVE, $event);
		$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
		$rows = $routine->save();
		$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_SCORES_REMOVE, $event);
		$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $routine]);
		}

		return NotUpdated(['model' => $routine]);
	}

	/**
	 * Sets the PerformanceChoreographyStatistic id
	 * 
	 * @param mixed $id
	 * @param mixed $performanceChoreographyStatisticId
	 * @return PayloadInterface
	 */
	public function setPerformanceChoreographyStatisticId($id, $performanceChoreographyStatisticId) {
		// find
		$routine = $this->get($id);

		if ($routine === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// update
		if ($routine->getPerformanceChoreographyStatisticId() !== $performanceChoreographyStatisticId) {
			$routine->setPerformanceChoreographyStatisticId($performanceChoreographyStatisticId);

			$event = new RoutineEvent($routine);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_CHOREOGRAPHY_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
			$routine->save();
			$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_CHOREOGRAPHY_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);
			
			return Updated(['model' => $routine]);
		}

		return NotUpdated(['model' => $routine]);
	}

	/**
	 * Sets the PerformanceExecutionStatistic id
	 * 
	 * @param mixed $id
	 * @param mixed $performanceExecutionStatisticId
	 * @return PayloadInterface
	 */
	public function setPerformanceExecutionStatisticId($id, $performanceExecutionStatisticId) {
		// find
		$routine = $this->get($id);

		if ($routine === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// update
		if ($routine->getPerformanceExecutionStatisticId() !== $performanceExecutionStatisticId) {
			$routine->setPerformanceExecutionStatisticId($performanceExecutionStatisticId);

			$event = new RoutineEvent($routine);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_EXECUTION_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
			$routine->save();
			$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_EXECUTION_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);
			
			return Updated(['model' => $routine]);
		}

		return NotUpdated(['model' => $routine]);
	}

	/**
	 * Sets the PerformanceMusicAndTimingStatistic id
	 * 
	 * @param mixed $id
	 * @param mixed $performanceMusicAndTimingStatisticId
	 * @return PayloadInterface
	 */
	public function setPerformanceMusicAndTimingStatisticId($id, $performanceMusicAndTimingStatisticId) {
		// find
		$routine = $this->get($id);

		if ($routine === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// update
		if ($routine->getPerformanceMusicAndTimingStatisticId() !== $performanceMusicAndTimingStatisticId) {
			$routine->setPerformanceMusicAndTimingStatisticId($performanceMusicAndTimingStatisticId);

			$event = new RoutineEvent($routine);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
			$routine->save();
			$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);
			
			return Updated(['model' => $routine]);
		}

		return NotUpdated(['model' => $routine]);
	}

	/**
	 * Sets the PerformanceTotalStatistic id
	 * 
	 * @param mixed $id
	 * @param mixed $performanceTotalStatisticId
	 * @return PayloadInterface
	 */
	public function setPerformanceTotalStatisticId($id, $performanceTotalStatisticId) {
		// find
		$routine = $this->get($id);

		if ($routine === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// update
		if ($routine->getPerformanceTotalStatisticId() !== $performanceTotalStatisticId) {
			$routine->setPerformanceTotalStatisticId($performanceTotalStatisticId);

			$event = new RoutineEvent($routine);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_TOTAL_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
			$routine->save();
			$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_TOTAL_STATISTIC_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);
			
			return Updated(['model' => $routine]);
		}

		return NotUpdated(['model' => $routine]);
	}

	/**
	 * Sets the Startgroup id
	 * 
	 * @param mixed $id
	 * @param mixed $startgroupId
	 * @return PayloadInterface
	 */
	public function setStartgroupId($id, $startgroupId) {
		// find
		$routine = $this->get($id);

		if ($routine === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// update
		if ($routine->getStartgroupId() !== $startgroupId) {
			$routine->setStartgroupId($startgroupId);

			$event = new RoutineEvent($routine);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(RoutineEvent::PRE_STARTGROUP_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
			$routine->save();
			$dispatcher->dispatch(RoutineEvent::POST_STARTGROUP_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);
			
			return Updated(['model' => $routine]);
		}

		return NotUpdated(['model' => $routine]);
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
		$routine = $this->get($id);

		if ($routine === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// hydrate
		$serializer = Routine::getSerializer();
		$routine = $serializer->hydrate($routine, $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($routine)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new RoutineEvent($routine);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(RoutineEvent::PRE_UPDATE, $event);
		$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
		$rows = $routine->save();
		$dispatcher->dispatch(RoutineEvent::POST_UPDATE, $event);
		$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);

		$payload = ['model' => $routine];

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
		$routine = $this->get($id);

		if ($routine === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// remove all relationships before
		PerformanceScoreQuery::create()->filterByRoutine($routine)->delete();

		// add them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for PerformanceScore';
			}
			$performanceScore = PerformanceScoreQuery::create()->findOneById($entry['id']);
			$routine->addPerformanceScore($performanceScore);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new RoutineEvent($routine);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_SCORES_UPDATE, $event);
		$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
		$rows = $routine->save();
		$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_SCORES_UPDATE, $event);
		$dispatcher->dispatch(RoutineEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $routine]);
		}

		return NotUpdated(['model' => $routine]);
	}

	/**
	 * Implement this functionality at iuf\junia\domain\RoutineDomain
	 * 
	 * @param RoutineQuery $query
	 * @param mixed $filter
	 * @return void
	 */
	abstract protected function applyFilter(RoutineQuery $query, $filter);

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

		$routine = RoutineQuery::create()->findOneById($id);
		$this->pool->set($id, $routine);

		return $routine;
	}

	/**
	 * Returns the service container
	 * 
	 * @return ServiceContainer
	 */
	abstract protected function getServiceContainer();
}

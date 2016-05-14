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

/**
 */
trait RoutineDomainTrait {

	/**
	 */
	protected $pool;

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
	 * Sets the PerformanceStatistics id
	 * 
	 * @param mixed $id
	 * @param mixed $performanceStatisticsId
	 * @return PayloadInterface
	 */
	public function setPerformanceStatisticsId($id, $performanceStatisticsId) {
		// find
		$routine = $this->get($id);

		if ($routine === null) {
			return new NotFound(['message' => 'Routine not found.']);
		}

		// update
		if ($routine->getPerformanceMusicAndTimingStatisticsId() !== $performanceStatisticsId) {
			$routine->setPerformanceMusicAndTimingStatisticsId($performanceStatisticsId);

			$event = new RoutineEvent($routine);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(RoutineEvent::PRE_PERFORMANCE_STATISTICS_UPDATE, $event);
			$dispatcher->dispatch(RoutineEvent::PRE_SAVE, $event);
			$routine->save();
			$dispatcher->dispatch(RoutineEvent::POST_PERFORMANCE_STATISTICS_UPDATE, $event);
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

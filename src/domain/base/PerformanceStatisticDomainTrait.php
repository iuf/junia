<?php
namespace iuf\junia\domain\base;

use iuf\junia\model\PerformanceStatistic;
use iuf\junia\model\PerformanceStatisticQuery;
use keeko\framework\service\ServiceContainer;
use keeko\framework\domain\payload\PayloadInterface;
use phootwork\collection\Map;
use keeko\framework\domain\payload\Found;
use keeko\framework\domain\payload\NotFound;
use keeko\framework\utils\Parameters;
use keeko\framework\utils\NameUtils;
use iuf\junia\event\PerformanceStatisticEvent;
use keeko\framework\domain\payload\Created;
use keeko\framework\domain\payload\NotValid;
use keeko\framework\domain\payload\Updated;
use keeko\framework\domain\payload\NotUpdated;
use keeko\framework\domain\payload\Deleted;
use keeko\framework\domain\payload\NotDeleted;

/**
 */
trait PerformanceStatisticDomainTrait {

	/**
	 */
	protected $pool;

	/**
	 * Creates a new PerformanceStatistic with the provided data
	 * 
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function create($data) {
		// hydrate
		$serializer = PerformanceStatistic::getSerializer();
		$performanceStatistic = $serializer->hydrate(new PerformanceStatistic(), $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($performanceStatistic)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new PerformanceStatisticEvent($performanceStatistic);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_CREATE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_SAVE, $event);
		$performanceStatistic->save();
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_CREATE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_SAVE, $event);
		return new Created(['model' => $performanceStatistic]);
	}

	/**
	 * Deletes a PerformanceStatistic with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function delete($id) {
		// find
		$performanceStatistic = $this->get($id);

		if ($performanceStatistic === null) {
			return new NotFound(['message' => 'PerformanceStatistic not found.']);
		}

		// delete
		$event = new PerformanceStatisticEvent($performanceStatistic);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_DELETE, $event);
		$performanceStatistic->delete();

		if ($performanceStatistic->isDeleted()) {
			$dispatcher->dispatch(PerformanceStatisticEvent::POST_DELETE, $event);
			return new Deleted(['model' => $performanceStatistic]);
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
		$performanceStatistic = $query->paginate($page, $size);

		// run response
		return new Found(['model' => $performanceStatistic]);
	}

	/**
	 * Returns one PerformanceStatistic with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function read($id) {
		// read
		$performanceStatistic = $this->get($id);

		// check existence
		if ($performanceStatistic === null) {
			return new NotFound(['message' => 'PerformanceStatistic not found.']);
		}

		return new Found(['model' => $performanceStatistic]);
	}

	/**
	 * Sets the Routine id
	 * 
	 * @param mixed $id
	 * @param mixed $routineId
	 * @return PayloadInterface
	 */
	public function setRoutineId($id, $routineId) {
		// find
		$performanceStatistic = $this->get($id);

		if ($performanceStatistic === null) {
			return new NotFound(['message' => 'PerformanceStatistic not found.']);
		}

		// update
		if ($performanceStatistic->getPerformanceMusicAndTimingStatisticId() !== $routineId) {
			$performanceStatistic->setPerformanceMusicAndTimingStatisticId($routineId);

			$event = new PerformanceStatisticEvent($performanceStatistic);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(PerformanceStatisticEvent::PRE_ROUTINE_UPDATE, $event);
			$dispatcher->dispatch(PerformanceStatisticEvent::PRE_SAVE, $event);
			$performanceStatistic->save();
			$dispatcher->dispatch(PerformanceStatisticEvent::POST_ROUTINE_UPDATE, $event);
			$dispatcher->dispatch(PerformanceStatisticEvent::POST_SAVE, $event);
			
			return Updated(['model' => $performanceStatistic]);
		}

		return NotUpdated(['model' => $performanceStatistic]);
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
		$performanceStatistic = $this->get($id);

		if ($performanceStatistic === null) {
			return new NotFound(['message' => 'PerformanceStatistic not found.']);
		}

		// hydrate
		$serializer = PerformanceStatistic::getSerializer();
		$performanceStatistic = $serializer->hydrate($performanceStatistic, $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($performanceStatistic)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new PerformanceStatisticEvent($performanceStatistic);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_UPDATE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::PRE_SAVE, $event);
		$rows = $performanceStatistic->save();
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_UPDATE, $event);
		$dispatcher->dispatch(PerformanceStatisticEvent::POST_SAVE, $event);

		$payload = ['model' => $performanceStatistic];

		if ($rows === 0) {
			return new NotUpdated($payload);
		}

		return new Updated($payload);
	}

	/**
	 * Implement this functionality at iuf\junia\domain\PerformanceStatisticDomain
	 * 
	 * @param PerformanceStatisticQuery $query
	 * @param mixed $filter
	 * @return void
	 */
	abstract protected function applyFilter(PerformanceStatisticQuery $query, $filter);

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

		$performanceStatistic = PerformanceStatisticQuery::create()->findOneById($id);
		$this->pool->set($id, $performanceStatistic);

		return $performanceStatistic;
	}

	/**
	 * Returns the service container
	 * 
	 * @return ServiceContainer
	 */
	abstract protected function getServiceContainer();
}

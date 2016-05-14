<?php
namespace iuf\junia\domain\base;

use iuf\junia\model\PerformanceScore;
use iuf\junia\model\PerformanceScoreQuery;
use keeko\framework\service\ServiceContainer;
use keeko\framework\domain\payload\PayloadInterface;
use phootwork\collection\Map;
use keeko\framework\domain\payload\Found;
use keeko\framework\domain\payload\NotFound;
use keeko\framework\utils\Parameters;
use keeko\framework\utils\NameUtils;
use iuf\junia\event\PerformanceScoreEvent;
use keeko\framework\domain\payload\Created;
use keeko\framework\domain\payload\NotValid;
use keeko\framework\domain\payload\Updated;
use keeko\framework\domain\payload\NotUpdated;
use keeko\framework\domain\payload\Deleted;
use keeko\framework\domain\payload\NotDeleted;

/**
 */
trait PerformanceScoreDomainTrait {

	/**
	 */
	protected $pool;

	/**
	 * Creates a new PerformanceScore with the provided data
	 * 
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function create($data) {
		// hydrate
		$serializer = PerformanceScore::getSerializer();
		$performanceScore = $serializer->hydrate(new PerformanceScore(), $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($performanceScore)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new PerformanceScoreEvent($performanceScore);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceScoreEvent::PRE_CREATE, $event);
		$dispatcher->dispatch(PerformanceScoreEvent::PRE_SAVE, $event);
		$performanceScore->save();
		$dispatcher->dispatch(PerformanceScoreEvent::POST_CREATE, $event);
		$dispatcher->dispatch(PerformanceScoreEvent::POST_SAVE, $event);
		return new Created(['model' => $performanceScore]);
	}

	/**
	 * Deletes a PerformanceScore with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function delete($id) {
		// find
		$performanceScore = $this->get($id);

		if ($performanceScore === null) {
			return new NotFound(['message' => 'PerformanceScore not found.']);
		}

		// delete
		$event = new PerformanceScoreEvent($performanceScore);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceScoreEvent::PRE_DELETE, $event);
		$performanceScore->delete();

		if ($performanceScore->isDeleted()) {
			$dispatcher->dispatch(PerformanceScoreEvent::POST_DELETE, $event);
			return new Deleted(['model' => $performanceScore]);
		}

		return new NotDeleted(['message' => 'Could not delete PerformanceScore']);
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

		$query = PerformanceScoreQuery::create();

		// sorting
		$sort = $params->getSort(PerformanceScore::getSerializer()->getSortFields());
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
		$performanceScore = $query->paginate($page, $size);

		// run response
		return new Found(['model' => $performanceScore]);
	}

	/**
	 * Returns one PerformanceScore with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function read($id) {
		// read
		$performanceScore = $this->get($id);

		// check existence
		if ($performanceScore === null) {
			return new NotFound(['message' => 'PerformanceScore not found.']);
		}

		return new Found(['model' => $performanceScore]);
	}

	/**
	 * Sets the Judge id
	 * 
	 * @param mixed $id
	 * @param mixed $judgeId
	 * @return PayloadInterface
	 */
	public function setJudgeId($id, $judgeId) {
		// find
		$performanceScore = $this->get($id);

		if ($performanceScore === null) {
			return new NotFound(['message' => 'PerformanceScore not found.']);
		}

		// update
		if ($performanceScore->getJudgeId() !== $judgeId) {
			$performanceScore->setJudgeId($judgeId);

			$event = new PerformanceScoreEvent($performanceScore);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(PerformanceScoreEvent::PRE_JUDGE_UPDATE, $event);
			$dispatcher->dispatch(PerformanceScoreEvent::PRE_SAVE, $event);
			$performanceScore->save();
			$dispatcher->dispatch(PerformanceScoreEvent::POST_JUDGE_UPDATE, $event);
			$dispatcher->dispatch(PerformanceScoreEvent::POST_SAVE, $event);
			
			return Updated(['model' => $performanceScore]);
		}

		return NotUpdated(['model' => $performanceScore]);
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
		$performanceScore = $this->get($id);

		if ($performanceScore === null) {
			return new NotFound(['message' => 'PerformanceScore not found.']);
		}

		// update
		if ($performanceScore->getRoutineId() !== $routineId) {
			$performanceScore->setRoutineId($routineId);

			$event = new PerformanceScoreEvent($performanceScore);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(PerformanceScoreEvent::PRE_ROUTINE_UPDATE, $event);
			$dispatcher->dispatch(PerformanceScoreEvent::PRE_SAVE, $event);
			$performanceScore->save();
			$dispatcher->dispatch(PerformanceScoreEvent::POST_ROUTINE_UPDATE, $event);
			$dispatcher->dispatch(PerformanceScoreEvent::POST_SAVE, $event);
			
			return Updated(['model' => $performanceScore]);
		}

		return NotUpdated(['model' => $performanceScore]);
	}

	/**
	 * Updates a PerformanceScore with the given idand the provided data
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function update($id, $data) {
		// find
		$performanceScore = $this->get($id);

		if ($performanceScore === null) {
			return new NotFound(['message' => 'PerformanceScore not found.']);
		}

		// hydrate
		$serializer = PerformanceScore::getSerializer();
		$performanceScore = $serializer->hydrate($performanceScore, $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($performanceScore)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new PerformanceScoreEvent($performanceScore);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceScoreEvent::PRE_UPDATE, $event);
		$dispatcher->dispatch(PerformanceScoreEvent::PRE_SAVE, $event);
		$rows = $performanceScore->save();
		$dispatcher->dispatch(PerformanceScoreEvent::POST_UPDATE, $event);
		$dispatcher->dispatch(PerformanceScoreEvent::POST_SAVE, $event);

		$payload = ['model' => $performanceScore];

		if ($rows === 0) {
			return new NotUpdated($payload);
		}

		return new Updated($payload);
	}

	/**
	 * Implement this functionality at iuf\junia\domain\PerformanceScoreDomain
	 * 
	 * @param PerformanceScoreQuery $query
	 * @param mixed $filter
	 * @return void
	 */
	abstract protected function applyFilter(PerformanceScoreQuery $query, $filter);

	/**
	 * Returns one PerformanceScore with the given id from cache
	 * 
	 * @param mixed $id
	 * @return PerformanceScore|null
	 */
	protected function get($id) {
		if ($this->pool === null) {
			$this->pool = new Map();
		} else if ($this->pool->has($id)) {
			return $this->pool->get($id);
		}

		$performanceScore = PerformanceScoreQuery::create()->findOneById($id);
		$this->pool->set($id, $performanceScore);

		return $performanceScore;
	}

	/**
	 * Returns the service container
	 * 
	 * @return ServiceContainer
	 */
	abstract protected function getServiceContainer();
}

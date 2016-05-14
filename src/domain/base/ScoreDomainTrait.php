<?php
namespace iuf\junia\domain\base;

use iuf\junia\model\Score;
use iuf\junia\model\ScoreQuery;
use keeko\framework\service\ServiceContainer;
use keeko\framework\domain\payload\PayloadInterface;
use phootwork\collection\Map;
use keeko\framework\domain\payload\Found;
use keeko\framework\domain\payload\NotFound;
use keeko\framework\utils\Parameters;
use keeko\framework\utils\NameUtils;
use iuf\junia\event\ScoreEvent;
use keeko\framework\domain\payload\Created;
use keeko\framework\domain\payload\NotValid;
use keeko\framework\domain\payload\Updated;
use keeko\framework\domain\payload\NotUpdated;
use keeko\framework\domain\payload\Deleted;
use keeko\framework\domain\payload\NotDeleted;

/**
 */
trait ScoreDomainTrait {

	/**
	 */
	protected $pool;

	/**
	 * Creates a new Score with the provided data
	 * 
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function create($data) {
		// hydrate
		$serializer = Score::getSerializer();
		$score = $serializer->hydrate(new Score(), $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($score)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new ScoreEvent($score);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(ScoreEvent::PRE_CREATE, $event);
		$dispatcher->dispatch(ScoreEvent::PRE_SAVE, $event);
		$score->save();
		$dispatcher->dispatch(ScoreEvent::POST_CREATE, $event);
		$dispatcher->dispatch(ScoreEvent::POST_SAVE, $event);
		return new Created(['model' => $score]);
	}

	/**
	 * Deletes a Score with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function delete($id) {
		// find
		$score = $this->get($id);

		if ($score === null) {
			return new NotFound(['message' => 'Score not found.']);
		}

		// delete
		$event = new ScoreEvent($score);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(ScoreEvent::PRE_DELETE, $event);
		$score->delete();

		if ($score->isDeleted()) {
			$dispatcher->dispatch(ScoreEvent::POST_DELETE, $event);
			return new Deleted(['model' => $score]);
		}

		return new NotDeleted(['message' => 'Could not delete Score']);
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

		$query = ScoreQuery::create();

		// sorting
		$sort = $params->getSort(Score::getSerializer()->getSortFields());
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
		$score = $query->paginate($page, $size);

		// run response
		return new Found(['model' => $score]);
	}

	/**
	 * Returns one Score with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function read($id) {
		// read
		$score = $this->get($id);

		// check existence
		if ($score === null) {
			return new NotFound(['message' => 'Score not found.']);
		}

		return new Found(['model' => $score]);
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
		$score = $this->get($id);

		if ($score === null) {
			return new NotFound(['message' => 'Score not found.']);
		}

		// update
		if ($score->getJudgeId() !== $judgeId) {
			$score->setJudgeId($judgeId);

			$event = new ScoreEvent($score);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(ScoreEvent::PRE_JUDGE_UPDATE, $event);
			$dispatcher->dispatch(ScoreEvent::PRE_SAVE, $event);
			$score->save();
			$dispatcher->dispatch(ScoreEvent::POST_JUDGE_UPDATE, $event);
			$dispatcher->dispatch(ScoreEvent::POST_SAVE, $event);
			
			return Updated(['model' => $score]);
		}

		return NotUpdated(['model' => $score]);
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
		$score = $this->get($id);

		if ($score === null) {
			return new NotFound(['message' => 'Score not found.']);
		}

		// update
		if ($score->getRoutineId() !== $routineId) {
			$score->setRoutineId($routineId);

			$event = new ScoreEvent($score);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(ScoreEvent::PRE_ROUTINE_UPDATE, $event);
			$dispatcher->dispatch(ScoreEvent::PRE_SAVE, $event);
			$score->save();
			$dispatcher->dispatch(ScoreEvent::POST_ROUTINE_UPDATE, $event);
			$dispatcher->dispatch(ScoreEvent::POST_SAVE, $event);
			
			return Updated(['model' => $score]);
		}

		return NotUpdated(['model' => $score]);
	}

	/**
	 * Updates a Score with the given idand the provided data
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function update($id, $data) {
		// find
		$score = $this->get($id);

		if ($score === null) {
			return new NotFound(['message' => 'Score not found.']);
		}

		// hydrate
		$serializer = Score::getSerializer();
		$score = $serializer->hydrate($score, $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($score)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new ScoreEvent($score);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(ScoreEvent::PRE_UPDATE, $event);
		$dispatcher->dispatch(ScoreEvent::PRE_SAVE, $event);
		$rows = $score->save();
		$dispatcher->dispatch(ScoreEvent::POST_UPDATE, $event);
		$dispatcher->dispatch(ScoreEvent::POST_SAVE, $event);

		$payload = ['model' => $score];

		if ($rows === 0) {
			return new NotUpdated($payload);
		}

		return new Updated($payload);
	}

	/**
	 * Implement this functionality at iuf\junia\domain\ScoreDomain
	 * 
	 * @param ScoreQuery $query
	 * @param mixed $filter
	 * @return void
	 */
	abstract protected function applyFilter(ScoreQuery $query, $filter);

	/**
	 * Returns one Score with the given id from cache
	 * 
	 * @param mixed $id
	 * @return Score|null
	 */
	protected function get($id) {
		if ($this->pool === null) {
			$this->pool = new Map();
		} else if ($this->pool->has($id)) {
			return $this->pool->get($id);
		}

		$score = ScoreQuery::create()->findOneById($id);
		$this->pool->set($id, $score);

		return $score;
	}

	/**
	 * Returns the service container
	 * 
	 * @return ServiceContainer
	 */
	abstract protected function getServiceContainer();
}

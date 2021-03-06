<?php
namespace iuf\junia\domain\base;

use iuf\junia\event\PerformanceScoreEvent;
use iuf\junia\model\PerformanceScoreQuery;
use iuf\junia\model\PerformanceScore;
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
		$model = $serializer->hydrate(new PerformanceScore(), $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($model)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new PerformanceScoreEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceScoreEvent::PRE_CREATE, $event);
		$dispatcher->dispatch(PerformanceScoreEvent::PRE_SAVE, $event);
		$model->save();
		$dispatcher->dispatch(PerformanceScoreEvent::POST_CREATE, $event);
		$dispatcher->dispatch(PerformanceScoreEvent::POST_SAVE, $event);
		return new Created(['model' => $model]);
	}

	/**
	 * Deletes a PerformanceScore with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function delete($id) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'PerformanceScore not found.']);
		}

		// delete
		$event = new PerformanceScoreEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceScoreEvent::PRE_DELETE, $event);
		$model->delete();

		if ($model->isDeleted()) {
			$dispatcher->dispatch(PerformanceScoreEvent::POST_DELETE, $event);
			return new Deleted(['model' => $model]);
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
		$model = $query->paginate($page, $size);

		// run response
		return new Found(['model' => $model]);
	}

	/**
	 * Returns one PerformanceScore with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function read($id) {
		// read
		$model = $this->get($id);

		// check existence
		if ($model === null) {
			return new NotFound(['message' => 'PerformanceScore not found.']);
		}

		return new Found(['model' => $model]);
	}

	/**
	 * Sets the Judge id
	 * 
	 * @param mixed $id
	 * @param mixed $relatedId
	 * @return PayloadInterface
	 */
	public function setJudgeId($id, $relatedId) {
		// find
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'PerformanceScore not found.']);
		}

		// update
		if ($model->getJudgeId() !== $relatedId) {
			$model->setJudgeId($relatedId);

			$event = new PerformanceScoreEvent($model);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(PerformanceScoreEvent::PRE_JUDGE_UPDATE, $event);
			$dispatcher->dispatch(PerformanceScoreEvent::PRE_SAVE, $event);
			$model->save();
			$dispatcher->dispatch(PerformanceScoreEvent::POST_JUDGE_UPDATE, $event);
			$dispatcher->dispatch(PerformanceScoreEvent::POST_SAVE, $event);
			
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
			return new NotFound(['message' => 'PerformanceScore not found.']);
		}

		// update
		if ($model->getRoutineId() !== $relatedId) {
			$model->setRoutineId($relatedId);

			$event = new PerformanceScoreEvent($model);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(PerformanceScoreEvent::PRE_ROUTINE_UPDATE, $event);
			$dispatcher->dispatch(PerformanceScoreEvent::PRE_SAVE, $event);
			$model->save();
			$dispatcher->dispatch(PerformanceScoreEvent::POST_ROUTINE_UPDATE, $event);
			$dispatcher->dispatch(PerformanceScoreEvent::POST_SAVE, $event);
			
			return Updated(['model' => $model]);
		}

		return NotUpdated(['model' => $model]);
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
		$model = $this->get($id);

		if ($model === null) {
			return new NotFound(['message' => 'PerformanceScore not found.']);
		}

		// hydrate
		$serializer = PerformanceScore::getSerializer();
		$model = $serializer->hydrate($model, $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($model)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new PerformanceScoreEvent($model);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceScoreEvent::PRE_UPDATE, $event);
		$dispatcher->dispatch(PerformanceScoreEvent::PRE_SAVE, $event);
		$rows = $model->save();
		$dispatcher->dispatch(PerformanceScoreEvent::POST_UPDATE, $event);
		$dispatcher->dispatch(PerformanceScoreEvent::POST_SAVE, $event);

		$payload = ['model' => $model];

		if ($rows === 0) {
			return new NotUpdated($payload);
		}

		return new Updated($payload);
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

		$model = PerformanceScoreQuery::create()->findOneById($id);
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

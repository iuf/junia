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

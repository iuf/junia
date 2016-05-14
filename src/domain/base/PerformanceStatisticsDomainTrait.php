<?php
namespace iuf\junia\domain\base;

use iuf\junia\model\PerformanceStatistics;
use iuf\junia\model\PerformanceStatisticsQuery;
use keeko\framework\service\ServiceContainer;
use keeko\framework\domain\payload\PayloadInterface;
use phootwork\collection\Map;
use keeko\framework\domain\payload\Found;
use keeko\framework\domain\payload\NotFound;
use keeko\framework\utils\Parameters;
use keeko\framework\utils\NameUtils;
use iuf\junia\event\PerformanceStatisticsEvent;
use keeko\framework\domain\payload\Created;
use keeko\framework\domain\payload\NotValid;
use keeko\framework\domain\payload\Updated;
use keeko\framework\domain\payload\NotUpdated;
use keeko\framework\domain\payload\Deleted;
use keeko\framework\domain\payload\NotDeleted;

/**
 */
trait PerformanceStatisticsDomainTrait {

	/**
	 */
	protected $pool;

	/**
	 * Creates a new PerformanceStatistics with the provided data
	 * 
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function create($data) {
		// hydrate
		$serializer = PerformanceStatistics::getSerializer();
		$performanceStatistics = $serializer->hydrate(new PerformanceStatistics(), $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($performanceStatistics)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new PerformanceStatisticsEvent($performanceStatistics);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticsEvent::PRE_CREATE, $event);
		$dispatcher->dispatch(PerformanceStatisticsEvent::PRE_SAVE, $event);
		$performanceStatistics->save();
		$dispatcher->dispatch(PerformanceStatisticsEvent::POST_CREATE, $event);
		$dispatcher->dispatch(PerformanceStatisticsEvent::POST_SAVE, $event);
		return new Created(['model' => $performanceStatistics]);
	}

	/**
	 * Deletes a PerformanceStatistics with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function delete($id) {
		// find
		$performanceStatistics = $this->get($id);

		if ($performanceStatistics === null) {
			return new NotFound(['message' => 'PerformanceStatistics not found.']);
		}

		// delete
		$event = new PerformanceStatisticsEvent($performanceStatistics);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticsEvent::PRE_DELETE, $event);
		$performanceStatistics->delete();

		if ($performanceStatistics->isDeleted()) {
			$dispatcher->dispatch(PerformanceStatisticsEvent::POST_DELETE, $event);
			return new Deleted(['model' => $performanceStatistics]);
		}

		return new NotDeleted(['message' => 'Could not delete PerformanceStatistics']);
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

		$query = PerformanceStatisticsQuery::create();

		// sorting
		$sort = $params->getSort(PerformanceStatistics::getSerializer()->getSortFields());
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
		$performanceStatistics = $query->paginate($page, $size);

		// run response
		return new Found(['model' => $performanceStatistics]);
	}

	/**
	 * Returns one PerformanceStatistics with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function read($id) {
		// read
		$performanceStatistics = $this->get($id);

		// check existence
		if ($performanceStatistics === null) {
			return new NotFound(['message' => 'PerformanceStatistics not found.']);
		}

		return new Found(['model' => $performanceStatistics]);
	}

	/**
	 * Updates a PerformanceStatistics with the given idand the provided data
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function update($id, $data) {
		// find
		$performanceStatistics = $this->get($id);

		if ($performanceStatistics === null) {
			return new NotFound(['message' => 'PerformanceStatistics not found.']);
		}

		// hydrate
		$serializer = PerformanceStatistics::getSerializer();
		$performanceStatistics = $serializer->hydrate($performanceStatistics, $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($performanceStatistics)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new PerformanceStatisticsEvent($performanceStatistics);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(PerformanceStatisticsEvent::PRE_UPDATE, $event);
		$dispatcher->dispatch(PerformanceStatisticsEvent::PRE_SAVE, $event);
		$rows = $performanceStatistics->save();
		$dispatcher->dispatch(PerformanceStatisticsEvent::POST_UPDATE, $event);
		$dispatcher->dispatch(PerformanceStatisticsEvent::POST_SAVE, $event);

		$payload = ['model' => $performanceStatistics];

		if ($rows === 0) {
			return new NotUpdated($payload);
		}

		return new Updated($payload);
	}

	/**
	 * Implement this functionality at iuf\junia\domain\PerformanceStatisticsDomain
	 * 
	 * @param PerformanceStatisticsQuery $query
	 * @param mixed $filter
	 * @return void
	 */
	abstract protected function applyFilter(PerformanceStatisticsQuery $query, $filter);

	/**
	 * Returns one PerformanceStatistics with the given id from cache
	 * 
	 * @param mixed $id
	 * @return PerformanceStatistics|null
	 */
	protected function get($id) {
		if ($this->pool === null) {
			$this->pool = new Map();
		} else if ($this->pool->has($id)) {
			return $this->pool->get($id);
		}

		$performanceStatistics = PerformanceStatisticsQuery::create()->findOneById($id);
		$this->pool->set($id, $performanceStatistics);

		return $performanceStatistics;
	}

	/**
	 * Returns the service container
	 * 
	 * @return ServiceContainer
	 */
	abstract protected function getServiceContainer();
}

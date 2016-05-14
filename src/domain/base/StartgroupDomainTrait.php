<?php
namespace iuf\junia\domain\base;

use iuf\junia\model\Startgroup;
use iuf\junia\model\StartgroupQuery;
use keeko\framework\service\ServiceContainer;
use keeko\framework\domain\payload\PayloadInterface;
use phootwork\collection\Map;
use keeko\framework\domain\payload\Found;
use keeko\framework\domain\payload\NotFound;
use keeko\framework\utils\Parameters;
use keeko\framework\utils\NameUtils;
use iuf\junia\event\StartgroupEvent;
use keeko\framework\domain\payload\Created;
use keeko\framework\domain\payload\NotValid;
use keeko\framework\domain\payload\Updated;
use keeko\framework\domain\payload\NotUpdated;
use keeko\framework\domain\payload\Deleted;
use keeko\framework\domain\payload\NotDeleted;

/**
 */
trait StartgroupDomainTrait {

	/**
	 */
	protected $pool;

	/**
	 * Creates a new Startgroup with the provided data
	 * 
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function create($data) {
		// hydrate
		$serializer = Startgroup::getSerializer();
		$startgroup = $serializer->hydrate(new Startgroup(), $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($startgroup)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new StartgroupEvent($startgroup);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(StartgroupEvent::PRE_CREATE, $event);
		$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
		$startgroup->save();
		$dispatcher->dispatch(StartgroupEvent::POST_CREATE, $event);
		$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);
		return new Created(['model' => $startgroup]);
	}

	/**
	 * Deletes a Startgroup with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function delete($id) {
		// find
		$startgroup = $this->get($id);

		if ($startgroup === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// delete
		$event = new StartgroupEvent($startgroup);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(StartgroupEvent::PRE_DELETE, $event);
		$startgroup->delete();

		if ($startgroup->isDeleted()) {
			$dispatcher->dispatch(StartgroupEvent::POST_DELETE, $event);
			return new Deleted(['model' => $startgroup]);
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
		$startgroup = $query->paginate($page, $size);

		// run response
		return new Found(['model' => $startgroup]);
	}

	/**
	 * Returns one Startgroup with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function read($id) {
		// read
		$startgroup = $this->get($id);

		// check existence
		if ($startgroup === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		return new Found(['model' => $startgroup]);
	}

	/**
	 * Sets the Competition id
	 * 
	 * @param mixed $id
	 * @param mixed $competitionId
	 * @return PayloadInterface
	 */
	public function setCompetitionId($id, $competitionId) {
		// find
		$startgroup = $this->get($id);

		if ($startgroup === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// update
		if ($startgroup->getCompetitionId() !== $competitionId) {
			$startgroup->setCompetitionId($competitionId);

			$event = new StartgroupEvent($startgroup);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(StartgroupEvent::PRE_COMPETITION_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
			$startgroup->save();
			$dispatcher->dispatch(StartgroupEvent::POST_COMPETITION_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);
			
			return Updated(['model' => $startgroup]);
		}

		return NotUpdated(['model' => $startgroup]);
	}

	/**
	 * Sets the Event id
	 * 
	 * @param mixed $id
	 * @param mixed $eventId
	 * @return PayloadInterface
	 */
	public function setEventId($id, $eventId) {
		// find
		$startgroup = $this->get($id);

		if ($startgroup === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// update
		if ($startgroup->getEventId() !== $eventId) {
			$startgroup->setEventId($eventId);

			$event = new StartgroupEvent($startgroup);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(StartgroupEvent::PRE_EVENT_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
			$startgroup->save();
			$dispatcher->dispatch(StartgroupEvent::POST_EVENT_UPDATE, $event);
			$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);
			
			return Updated(['model' => $startgroup]);
		}

		return NotUpdated(['model' => $startgroup]);
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
		$startgroup = $this->get($id);

		if ($startgroup === null) {
			return new NotFound(['message' => 'Startgroup not found.']);
		}

		// hydrate
		$serializer = Startgroup::getSerializer();
		$startgroup = $serializer->hydrate($startgroup, $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($startgroup)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new StartgroupEvent($startgroup);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(StartgroupEvent::PRE_UPDATE, $event);
		$dispatcher->dispatch(StartgroupEvent::PRE_SAVE, $event);
		$rows = $startgroup->save();
		$dispatcher->dispatch(StartgroupEvent::POST_UPDATE, $event);
		$dispatcher->dispatch(StartgroupEvent::POST_SAVE, $event);

		$payload = ['model' => $startgroup];

		if ($rows === 0) {
			return new NotUpdated($payload);
		}

		return new Updated($payload);
	}

	/**
	 * Implement this functionality at iuf\junia\domain\StartgroupDomain
	 * 
	 * @param StartgroupQuery $query
	 * @param mixed $filter
	 * @return void
	 */
	abstract protected function applyFilter(StartgroupQuery $query, $filter);

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

		$startgroup = StartgroupQuery::create()->findOneById($id);
		$this->pool->set($id, $startgroup);

		return $startgroup;
	}

	/**
	 * Returns the service container
	 * 
	 * @return ServiceContainer
	 */
	abstract protected function getServiceContainer();
}

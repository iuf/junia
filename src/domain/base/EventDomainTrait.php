<?php
namespace iuf\junia\domain\base;

use iuf\junia\model\Event;
use iuf\junia\model\EventQuery;
use keeko\framework\service\ServiceContainer;
use keeko\framework\domain\payload\PayloadInterface;
use phootwork\collection\Map;
use keeko\framework\domain\payload\Found;
use keeko\framework\domain\payload\NotFound;
use keeko\framework\utils\Parameters;
use keeko\framework\utils\NameUtils;
use iuf\junia\event\EventEvent;
use keeko\framework\domain\payload\Created;
use keeko\framework\domain\payload\NotValid;
use keeko\framework\domain\payload\Updated;
use keeko\framework\domain\payload\NotUpdated;
use keeko\framework\domain\payload\Deleted;
use keeko\framework\domain\payload\NotDeleted;
use iuf\junia\model\StartgroupQuery;

/**
 */
trait EventDomainTrait {

	/**
	 */
	protected $pool;

	/**
	 * Adds Startgroups to Event
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function addStartgroups($id, $data) {
		// find
		$event = $this->get($id);

		if ($event === null) {
			return new NotFound(['message' => 'Event not found.']);
		}
		 
		// update
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Startgroup';
			}
			$startgroup = StartgroupQuery::create()->findOneById($entry['id']);
			$event->addStartgroup($startgroup);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new EventEvent($event);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(EventEvent::PRE_STARTGROUPS_ADD, $event);
		$dispatcher->dispatch(EventEvent::PRE_SAVE, $event);
		$rows = $event->save();
		$dispatcher->dispatch(EventEvent::POST_STARTGROUPS_ADD, $event);
		$dispatcher->dispatch(EventEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $event]);
		}

		return NotUpdated(['model' => $event]);
	}

	/**
	 * Creates a new Event with the provided data
	 * 
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function create($data) {
		// hydrate
		$serializer = Event::getSerializer();
		$event = $serializer->hydrate(new Event(), $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($event)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new EventEvent($event);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(EventEvent::PRE_CREATE, $event);
		$dispatcher->dispatch(EventEvent::PRE_SAVE, $event);
		$event->save();
		$dispatcher->dispatch(EventEvent::POST_CREATE, $event);
		$dispatcher->dispatch(EventEvent::POST_SAVE, $event);
		return new Created(['model' => $event]);
	}

	/**
	 * Deletes a Event with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function delete($id) {
		// find
		$event = $this->get($id);

		if ($event === null) {
			return new NotFound(['message' => 'Event not found.']);
		}

		// delete
		$event = new EventEvent($event);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(EventEvent::PRE_DELETE, $event);
		$event->delete();

		if ($event->isDeleted()) {
			$dispatcher->dispatch(EventEvent::POST_DELETE, $event);
			return new Deleted(['model' => $event]);
		}

		return new NotDeleted(['message' => 'Could not delete Event']);
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

		$query = EventQuery::create();

		// sorting
		$sort = $params->getSort(Event::getSerializer()->getSortFields());
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
		$event = $query->paginate($page, $size);

		// run response
		return new Found(['model' => $event]);
	}

	/**
	 * Returns one Event with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function read($id) {
		// read
		$event = $this->get($id);

		// check existence
		if ($event === null) {
			return new NotFound(['message' => 'Event not found.']);
		}

		return new Found(['model' => $event]);
	}

	/**
	 * Removes Startgroups from Event
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function removeStartgroups($id, $data) {
		// find
		$event = $this->get($id);

		if ($event === null) {
			return new NotFound(['message' => 'Event not found.']);
		}

		// remove them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Startgroup';
			}
			$startgroup = StartgroupQuery::create()->findOneById($entry['id']);
			$event->removeStartgroup($startgroup);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new EventEvent($event);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(EventEvent::PRE_STARTGROUPS_REMOVE, $event);
		$dispatcher->dispatch(EventEvent::PRE_SAVE, $event);
		$rows = $event->save();
		$dispatcher->dispatch(EventEvent::POST_STARTGROUPS_REMOVE, $event);
		$dispatcher->dispatch(EventEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $event]);
		}

		return NotUpdated(['model' => $event]);
	}

	/**
	 * Updates a Event with the given idand the provided data
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function update($id, $data) {
		// find
		$event = $this->get($id);

		if ($event === null) {
			return new NotFound(['message' => 'Event not found.']);
		}

		// hydrate
		$serializer = Event::getSerializer();
		$event = $serializer->hydrate($event, $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($event)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new EventEvent($event);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(EventEvent::PRE_UPDATE, $event);
		$dispatcher->dispatch(EventEvent::PRE_SAVE, $event);
		$rows = $event->save();
		$dispatcher->dispatch(EventEvent::POST_UPDATE, $event);
		$dispatcher->dispatch(EventEvent::POST_SAVE, $event);

		$payload = ['model' => $event];

		if ($rows === 0) {
			return new NotUpdated($payload);
		}

		return new Updated($payload);
	}

	/**
	 * Updates Startgroups on Event
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function updateStartgroups($id, $data) {
		// find
		$event = $this->get($id);

		if ($event === null) {
			return new NotFound(['message' => 'Event not found.']);
		}

		// remove all relationships before
		StartgroupQuery::create()->filterByEvent($event)->delete();

		// add them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Startgroup';
			}
			$startgroup = StartgroupQuery::create()->findOneById($entry['id']);
			$event->addStartgroup($startgroup);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new EventEvent($event);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(EventEvent::PRE_STARTGROUPS_UPDATE, $event);
		$dispatcher->dispatch(EventEvent::PRE_SAVE, $event);
		$rows = $event->save();
		$dispatcher->dispatch(EventEvent::POST_STARTGROUPS_UPDATE, $event);
		$dispatcher->dispatch(EventEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $event]);
		}

		return NotUpdated(['model' => $event]);
	}

	/**
	 * Implement this functionality at iuf\junia\domain\EventDomain
	 * 
	 * @param EventQuery $query
	 * @param mixed $filter
	 * @return void
	 */
	abstract protected function applyFilter(EventQuery $query, $filter);

	/**
	 * Returns one Event with the given id from cache
	 * 
	 * @param mixed $id
	 * @return Event|null
	 */
	protected function get($id) {
		if ($this->pool === null) {
			$this->pool = new Map();
		} else if ($this->pool->has($id)) {
			return $this->pool->get($id);
		}

		$event = EventQuery::create()->findOneById($id);
		$this->pool->set($id, $event);

		return $event;
	}

	/**
	 * Returns the service container
	 * 
	 * @return ServiceContainer
	 */
	abstract protected function getServiceContainer();
}

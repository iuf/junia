<?php
namespace iuf\junia\domain\base;

use iuf\junia\model\Competition;
use iuf\junia\model\CompetitionQuery;
use keeko\framework\service\ServiceContainer;
use keeko\framework\domain\payload\PayloadInterface;
use phootwork\collection\Map;
use keeko\framework\domain\payload\Found;
use keeko\framework\domain\payload\NotFound;
use keeko\framework\utils\Parameters;
use keeko\framework\utils\NameUtils;
use iuf\junia\event\CompetitionEvent;
use keeko\framework\domain\payload\Created;
use keeko\framework\domain\payload\NotValid;
use keeko\framework\domain\payload\Updated;
use keeko\framework\domain\payload\NotUpdated;
use keeko\framework\domain\payload\Deleted;
use keeko\framework\domain\payload\NotDeleted;
use iuf\junia\model\StartgroupQuery;

/**
 */
trait CompetitionDomainTrait {

	/**
	 */
	protected $pool;

	/**
	 * Adds Startgroups to Competition
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function addStartgroups($id, $data) {
		// find
		$competition = $this->get($id);

		if ($competition === null) {
			return new NotFound(['message' => 'Competition not found.']);
		}
		 
		// update
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Startgroup';
			}
			$startgroup = StartgroupQuery::create()->findOneById($entry['id']);
			$competition->addStartgroup($startgroup);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new CompetitionEvent($competition);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(CompetitionEvent::PRE_STARTGROUPS_ADD, $event);
		$dispatcher->dispatch(CompetitionEvent::PRE_SAVE, $event);
		$rows = $competition->save();
		$dispatcher->dispatch(CompetitionEvent::POST_STARTGROUPS_ADD, $event);
		$dispatcher->dispatch(CompetitionEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $competition]);
		}

		return NotUpdated(['model' => $competition]);
	}

	/**
	 * Creates a new Competition with the provided data
	 * 
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function create($data) {
		// hydrate
		$serializer = Competition::getSerializer();
		$competition = $serializer->hydrate(new Competition(), $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($competition)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new CompetitionEvent($competition);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(CompetitionEvent::PRE_CREATE, $event);
		$dispatcher->dispatch(CompetitionEvent::PRE_SAVE, $event);
		$competition->save();
		$dispatcher->dispatch(CompetitionEvent::POST_CREATE, $event);
		$dispatcher->dispatch(CompetitionEvent::POST_SAVE, $event);
		return new Created(['model' => $competition]);
	}

	/**
	 * Deletes a Competition with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function delete($id) {
		// find
		$competition = $this->get($id);

		if ($competition === null) {
			return new NotFound(['message' => 'Competition not found.']);
		}

		// delete
		$event = new CompetitionEvent($competition);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(CompetitionEvent::PRE_DELETE, $event);
		$competition->delete();

		if ($competition->isDeleted()) {
			$dispatcher->dispatch(CompetitionEvent::POST_DELETE, $event);
			return new Deleted(['model' => $competition]);
		}

		return new NotDeleted(['message' => 'Could not delete Competition']);
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

		$query = CompetitionQuery::create();

		// sorting
		$sort = $params->getSort(Competition::getSerializer()->getSortFields());
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
		$competition = $query->paginate($page, $size);

		// run response
		return new Found(['model' => $competition]);
	}

	/**
	 * Returns one Competition with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function read($id) {
		// read
		$competition = $this->get($id);

		// check existence
		if ($competition === null) {
			return new NotFound(['message' => 'Competition not found.']);
		}

		return new Found(['model' => $competition]);
	}

	/**
	 * Removes Startgroups from Competition
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function removeStartgroups($id, $data) {
		// find
		$competition = $this->get($id);

		if ($competition === null) {
			return new NotFound(['message' => 'Competition not found.']);
		}

		// remove them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Startgroup';
			}
			$startgroup = StartgroupQuery::create()->findOneById($entry['id']);
			$competition->removeStartgroup($startgroup);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new CompetitionEvent($competition);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(CompetitionEvent::PRE_STARTGROUPS_REMOVE, $event);
		$dispatcher->dispatch(CompetitionEvent::PRE_SAVE, $event);
		$rows = $competition->save();
		$dispatcher->dispatch(CompetitionEvent::POST_STARTGROUPS_REMOVE, $event);
		$dispatcher->dispatch(CompetitionEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $competition]);
		}

		return NotUpdated(['model' => $competition]);
	}

	/**
	 * Updates a Competition with the given idand the provided data
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function update($id, $data) {
		// find
		$competition = $this->get($id);

		if ($competition === null) {
			return new NotFound(['message' => 'Competition not found.']);
		}

		// hydrate
		$serializer = Competition::getSerializer();
		$competition = $serializer->hydrate($competition, $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($competition)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new CompetitionEvent($competition);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(CompetitionEvent::PRE_UPDATE, $event);
		$dispatcher->dispatch(CompetitionEvent::PRE_SAVE, $event);
		$rows = $competition->save();
		$dispatcher->dispatch(CompetitionEvent::POST_UPDATE, $event);
		$dispatcher->dispatch(CompetitionEvent::POST_SAVE, $event);

		$payload = ['model' => $competition];

		if ($rows === 0) {
			return new NotUpdated($payload);
		}

		return new Updated($payload);
	}

	/**
	 * Updates Startgroups on Competition
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function updateStartgroups($id, $data) {
		// find
		$competition = $this->get($id);

		if ($competition === null) {
			return new NotFound(['message' => 'Competition not found.']);
		}

		// remove all relationships before
		StartgroupQuery::create()->filterByCompetition($competition)->delete();

		// add them
		$errors = [];
		foreach ($data as $entry) {
			if (!isset($entry['id'])) {
				$errors[] = 'Missing id for Startgroup';
			}
			$startgroup = StartgroupQuery::create()->findOneById($entry['id']);
			$competition->addStartgroup($startgroup);
		}

		if (count($errors) > 0) {
			return new NotValid(['errors' => $errors]);
		}

		// save and dispatch events
		$event = new CompetitionEvent($competition);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(CompetitionEvent::PRE_STARTGROUPS_UPDATE, $event);
		$dispatcher->dispatch(CompetitionEvent::PRE_SAVE, $event);
		$rows = $competition->save();
		$dispatcher->dispatch(CompetitionEvent::POST_STARTGROUPS_UPDATE, $event);
		$dispatcher->dispatch(CompetitionEvent::POST_SAVE, $event);

		if ($rows > 0) {
			return Updated(['model' => $competition]);
		}

		return NotUpdated(['model' => $competition]);
	}

	/**
	 * Implement this functionality at iuf\junia\domain\CompetitionDomain
	 * 
	 * @param CompetitionQuery $query
	 * @param mixed $filter
	 * @return void
	 */
	abstract protected function applyFilter(CompetitionQuery $query, $filter);

	/**
	 * Returns one Competition with the given id from cache
	 * 
	 * @param mixed $id
	 * @return Competition|null
	 */
	protected function get($id) {
		if ($this->pool === null) {
			$this->pool = new Map();
		} else if ($this->pool->has($id)) {
			return $this->pool->get($id);
		}

		$competition = CompetitionQuery::create()->findOneById($id);
		$this->pool->set($id, $competition);

		return $competition;
	}

	/**
	 * Returns the service container
	 * 
	 * @return ServiceContainer
	 */
	abstract protected function getServiceContainer();
}

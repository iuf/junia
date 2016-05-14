<?php
namespace iuf\junia\domain\base;

use iuf\junia\model\Judge;
use iuf\junia\model\JudgeQuery;
use keeko\framework\service\ServiceContainer;
use keeko\framework\domain\payload\PayloadInterface;
use phootwork\collection\Map;
use keeko\framework\domain\payload\Found;
use keeko\framework\domain\payload\NotFound;
use keeko\framework\utils\Parameters;
use keeko\framework\utils\NameUtils;
use iuf\junia\event\JudgeEvent;
use keeko\framework\domain\payload\Created;
use keeko\framework\domain\payload\NotValid;
use keeko\framework\domain\payload\Updated;
use keeko\framework\domain\payload\NotUpdated;
use keeko\framework\domain\payload\Deleted;
use keeko\framework\domain\payload\NotDeleted;

/**
 */
trait JudgeDomainTrait {

	/**
	 */
	protected $pool;

	/**
	 * Creates a new Judge with the provided data
	 * 
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function create($data) {
		// hydrate
		$serializer = Judge::getSerializer();
		$judge = $serializer->hydrate(new Judge(), $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($judge)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new JudgeEvent($judge);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(JudgeEvent::PRE_CREATE, $event);
		$dispatcher->dispatch(JudgeEvent::PRE_SAVE, $event);
		$judge->save();
		$dispatcher->dispatch(JudgeEvent::POST_CREATE, $event);
		$dispatcher->dispatch(JudgeEvent::POST_SAVE, $event);
		return new Created(['model' => $judge]);
	}

	/**
	 * Deletes a Judge with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function delete($id) {
		// find
		$judge = $this->get($id);

		if ($judge === null) {
			return new NotFound(['message' => 'Judge not found.']);
		}

		// delete
		$event = new JudgeEvent($judge);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(JudgeEvent::PRE_DELETE, $event);
		$judge->delete();

		if ($judge->isDeleted()) {
			$dispatcher->dispatch(JudgeEvent::POST_DELETE, $event);
			return new Deleted(['model' => $judge]);
		}

		return new NotDeleted(['message' => 'Could not delete Judge']);
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

		$query = JudgeQuery::create();

		// sorting
		$sort = $params->getSort(Judge::getSerializer()->getSortFields());
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
		$judge = $query->paginate($page, $size);

		// run response
		return new Found(['model' => $judge]);
	}

	/**
	 * Returns one Judge with the given id
	 * 
	 * @param mixed $id
	 * @return PayloadInterface
	 */
	public function read($id) {
		// read
		$judge = $this->get($id);

		// check existence
		if ($judge === null) {
			return new NotFound(['message' => 'Judge not found.']);
		}

		return new Found(['model' => $judge]);
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
		$judge = $this->get($id);

		if ($judge === null) {
			return new NotFound(['message' => 'Judge not found.']);
		}

		// update
		if ($judge->getStartgroupId() !== $startgroupId) {
			$judge->setStartgroupId($startgroupId);

			$event = new JudgeEvent($judge);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(JudgeEvent::PRE_STARTGROUP_UPDATE, $event);
			$dispatcher->dispatch(JudgeEvent::PRE_SAVE, $event);
			$judge->save();
			$dispatcher->dispatch(JudgeEvent::POST_STARTGROUP_UPDATE, $event);
			$dispatcher->dispatch(JudgeEvent::POST_SAVE, $event);
			
			return Updated(['model' => $judge]);
		}

		return NotUpdated(['model' => $judge]);
	}

	/**
	 * Sets the User id
	 * 
	 * @param mixed $id
	 * @param mixed $userId
	 * @return PayloadInterface
	 */
	public function setUserId($id, $userId) {
		// find
		$judge = $this->get($id);

		if ($judge === null) {
			return new NotFound(['message' => 'Judge not found.']);
		}

		// update
		if ($judge->getUserId() !== $userId) {
			$judge->setUserId($userId);

			$event = new JudgeEvent($judge);
			$dispatcher = $this->getServiceContainer()->getDispatcher();
			$dispatcher->dispatch(JudgeEvent::PRE_USER_UPDATE, $event);
			$dispatcher->dispatch(JudgeEvent::PRE_SAVE, $event);
			$judge->save();
			$dispatcher->dispatch(JudgeEvent::POST_USER_UPDATE, $event);
			$dispatcher->dispatch(JudgeEvent::POST_SAVE, $event);
			
			return Updated(['model' => $judge]);
		}

		return NotUpdated(['model' => $judge]);
	}

	/**
	 * Updates a Judge with the given idand the provided data
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return PayloadInterface
	 */
	public function update($id, $data) {
		// find
		$judge = $this->get($id);

		if ($judge === null) {
			return new NotFound(['message' => 'Judge not found.']);
		}

		// hydrate
		$serializer = Judge::getSerializer();
		$judge = $serializer->hydrate($judge, $data);

		// validate
		$validator = $this->getValidator();
		if ($validator !== null && !$validator->validate($judge)) {
			return new NotValid([
				'errors' => $validator->getValidationFailures()
			]);
		}

		// dispatch
		$event = new JudgeEvent($judge);
		$dispatcher = $this->getServiceContainer()->getDispatcher();
		$dispatcher->dispatch(JudgeEvent::PRE_UPDATE, $event);
		$dispatcher->dispatch(JudgeEvent::PRE_SAVE, $event);
		$rows = $judge->save();
		$dispatcher->dispatch(JudgeEvent::POST_UPDATE, $event);
		$dispatcher->dispatch(JudgeEvent::POST_SAVE, $event);

		$payload = ['model' => $judge];

		if ($rows === 0) {
			return new NotUpdated($payload);
		}

		return new Updated($payload);
	}

	/**
	 * Implement this functionality at iuf\junia\domain\JudgeDomain
	 * 
	 * @param JudgeQuery $query
	 * @param mixed $filter
	 * @return void
	 */
	abstract protected function applyFilter(JudgeQuery $query, $filter);

	/**
	 * Returns one Judge with the given id from cache
	 * 
	 * @param mixed $id
	 * @return Judge|null
	 */
	protected function get($id) {
		if ($this->pool === null) {
			$this->pool = new Map();
		} else if ($this->pool->has($id)) {
			return $this->pool->get($id);
		}

		$judge = JudgeQuery::create()->findOneById($id);
		$this->pool->set($id, $judge);

		return $judge;
	}

	/**
	 * Returns the service container
	 * 
	 * @return ServiceContainer
	 */
	abstract protected function getServiceContainer();
}

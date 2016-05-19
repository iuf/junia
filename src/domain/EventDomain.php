<?php
namespace iuf\junia\domain;

use keeko\framework\foundation\AbstractDomain;
use iuf\junia\model\EventQuery;
use iuf\junia\domain\base\EventDomainTrait;

/**
 */
class EventDomain extends AbstractDomain {

	use EventDomainTrait;

	/**
	 * @param EventQuery $query
	 * @param mixed $filter
	 */
	protected function applyFilter(EventQuery $query, $filter) {
	}
}

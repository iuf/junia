<?php
namespace iuf\junia\domain;

use keeko\framework\foundation\AbstractDomain;
use iuf\junia\model\RoutineQuery;
use iuf\junia\domain\base\RoutineDomainTrait;

/**
 */
class RoutineDomain extends AbstractDomain {

	use RoutineDomainTrait;

	/**
	 * @param RoutineQuery $query
	 * @param mixed $filter
	 */
	protected function applyFilter(RoutineQuery $query, $filter) {
	}
}

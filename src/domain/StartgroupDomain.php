<?php
namespace iuf\junia\domain;

use keeko\framework\foundation\AbstractDomain;
use iuf\junia\model\StartgroupQuery;
use iuf\junia\domain\base\StartgroupDomainTrait;

/**
 */
class StartgroupDomain extends AbstractDomain {

	use StartgroupDomainTrait;

	/**
	 * @param StartgroupQuery $query
	 * @param mixed $filter
	 */
	protected function applyFilter(StartgroupQuery $query, $filter) {
	}
}

<?php
namespace iuf\junia\domain;

use keeko\framework\foundation\AbstractDomain;
use iuf\junia\model\PerformanceStatisticQuery;
use iuf\junia\domain\base\PerformanceStatisticDomainTrait;

/**
 */
class PerformanceStatisticDomain extends AbstractDomain {

	use PerformanceStatisticDomainTrait;

	/**
	 * @param PerformanceStatisticQuery $query
	 * @param mixed $filter
	 */
	protected function applyFilter(PerformanceStatisticQuery $query, $filter) {
	}
}

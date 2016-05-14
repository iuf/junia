<?php
namespace iuf\junia\domain;

use keeko\framework\foundation\AbstractDomain;
use iuf\junia\model\PerformanceStatisticsQuery;
use iuf\junia\domain\base\PerformanceStatisticsDomainTrait;

/**
 */
class PerformanceStatisticsDomain extends AbstractDomain {

	use PerformanceStatisticsDomainTrait;

	/**
	 * @param PerformanceStatisticsQuery $query
	 * @param mixed $filter
	 */
	protected function applyFilter(PerformanceStatisticsQuery $query, $filter) {
	}
}

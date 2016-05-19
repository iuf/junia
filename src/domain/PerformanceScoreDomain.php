<?php
namespace iuf\junia\domain;

use keeko\framework\foundation\AbstractDomain;
use iuf\junia\model\PerformanceScoreQuery;
use iuf\junia\domain\base\PerformanceScoreDomainTrait;

/**
 */
class PerformanceScoreDomain extends AbstractDomain {

	use PerformanceScoreDomainTrait;

	/**
	 * @param PerformanceScoreQuery $query
	 * @param mixed $filter
	 */
	protected function applyFilter(PerformanceScoreQuery $query, $filter) {
	}
}

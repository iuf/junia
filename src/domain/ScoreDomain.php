<?php
namespace iuf\junia\domain;

use keeko\framework\foundation\AbstractDomain;
use iuf\junia\model\ScoreQuery;
use iuf\junia\domain\base\ScoreDomainTrait;

/**
 */
class ScoreDomain extends AbstractDomain {

	use ScoreDomainTrait;

	/**
	 * @param ScoreQuery $query
	 * @param mixed $filter
	 */
	protected function applyFilter(ScoreQuery $query, $filter) {
	}
}

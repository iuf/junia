<?php
namespace iuf\junia\domain;

use keeko\framework\foundation\AbstractDomain;
use iuf\junia\model\JudgeQuery;
use iuf\junia\domain\base\JudgeDomainTrait;

/**
 */
class JudgeDomain extends AbstractDomain {

	use JudgeDomainTrait;

	/**
	 * @param JudgeQuery $query
	 * @param mixed $filter
	 */
	protected function applyFilter(JudgeQuery $query, $filter) {
	}
}

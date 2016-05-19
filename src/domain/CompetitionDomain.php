<?php
namespace iuf\junia\domain;

use keeko\framework\foundation\AbstractDomain;
use iuf\junia\model\CompetitionQuery;
use iuf\junia\domain\base\CompetitionDomainTrait;

/**
 */
class CompetitionDomain extends AbstractDomain {

	use CompetitionDomainTrait;

	/**
	 * @param CompetitionQuery $query
	 * @param mixed $filter
	 */
	protected function applyFilter(CompetitionQuery $query, $filter) {
	}
}

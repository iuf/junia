<?php
namespace iuf\junia\domain;

use keeko\framework\foundation\AbstractDomain;
use iuf\junia\model\EventQuery;
use iuf\junia\domain\base\EventDomainTrait;
use keeko\framework\utils\NameUtils;

/**
 */
class EventDomain extends AbstractDomain {

	use EventDomainTrait;

	/**
	 * @param EventQuery $query
	 * @param mixed $filter
	 */
	protected function applyFilter(EventQuery $query, $filter) {
		foreach ($filter as $column => $value) {
		    $method = 'filterBy' . NameUtils::toStudlyCase($column);
		    $query->{$method}($value);
		}
	}
}

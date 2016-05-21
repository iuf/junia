<?php
namespace iuf\junia\event;

use iuf\junia\model\PerformanceStatistic;
use Symfony\Component\EventDispatcher\Event;

/**
 */
class PerformanceStatisticEvent extends Event {

	/**
	 */
	const POST_CREATE = 'iuf.junia.performance_statistic.post_create';

	/**
	 */
	const POST_DELETE = 'iuf.junia.performance_statistic.post_delete';

	/**
	 */
	const POST_EVENTS_ADD = 'iuf.junia.performance_statistic.post_events_add';

	/**
	 */
	const POST_EVENTS_REMOVE = 'iuf.junia.performance_statistic.post_events_add';

	/**
	 */
	const POST_EVENTS_UPDATE = 'iuf.junia.performance_statistic.post_events_update';

	/**
	 */
	const POST_ROUTINE_UPDATE = 'iuf.junia.performance_statistic.post_routine_update';

	/**
	 */
	const POST_SAVE = 'iuf.junia.performance_statistic.post_save';

	/**
	 */
	const POST_STARTGROUPS_ADD = 'iuf.junia.performance_statistic.post_startgroups_add';

	/**
	 */
	const POST_STARTGROUPS_REMOVE = 'iuf.junia.performance_statistic.post_startgroups_add';

	/**
	 */
	const POST_STARTGROUPS_UPDATE = 'iuf.junia.performance_statistic.post_startgroups_update';

	/**
	 */
	const POST_UPDATE = 'iuf.junia.performance_statistic.post_update';

	/**
	 */
	const PRE_CREATE = 'iuf.junia.performance_statistic.pre_create';

	/**
	 */
	const PRE_DELETE = 'iuf.junia.performance_statistic.pre_delete';

	/**
	 */
	const PRE_EVENTS_ADD = 'iuf.junia.performance_statistic.pre_events_add';

	/**
	 */
	const PRE_EVENTS_REMOVE = 'iuf.junia.performance_statistic.pre_events_add';

	/**
	 */
	const PRE_EVENTS_UPDATE = 'iuf.junia.performance_statistic.pre_events_update';

	/**
	 */
	const PRE_ROUTINE_UPDATE = 'iuf.junia.performance_statistic.pre_routine_update';

	/**
	 */
	const PRE_SAVE = 'iuf.junia.performance_statistic.pre_save';

	/**
	 */
	const PRE_STARTGROUPS_ADD = 'iuf.junia.performance_statistic.pre_startgroups_add';

	/**
	 */
	const PRE_STARTGROUPS_REMOVE = 'iuf.junia.performance_statistic.pre_startgroups_add';

	/**
	 */
	const PRE_STARTGROUPS_UPDATE = 'iuf.junia.performance_statistic.pre_startgroups_update';

	/**
	 */
	const PRE_UPDATE = 'iuf.junia.performance_statistic.pre_update';

	/**
	 */
	protected $performanceStatistic;

	/**
	 * @param PerformanceStatistic $performanceStatistic
	 */
	public function __construct(PerformanceStatistic $performanceStatistic) {
		$this->performanceStatistic = $performanceStatistic;
	}

	/**
	 * @return PerformanceStatistic
	 */
	public function getPerformanceStatistic() {
		return $this->performanceStatistic;
	}
}

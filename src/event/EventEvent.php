<?php
namespace iuf\junia\event;

use iuf\junia\model\Event as Model;
use Symfony\Component\EventDispatcher\Event;

/**
 */
class EventEvent extends Event {

	/**
	 */
	const POST_CREATE = 'iuf.junia.event.post_create';

	/**
	 */
	const POST_DELETE = 'iuf.junia.event.post_delete';

	/**
	 */
	const POST_PERFORMANCE_CHOREOGRAPHY_STATISTIC_UPDATE = 'iuf.junia.event.post_performance_choreography_statistic_update';

	/**
	 */
	const POST_PERFORMANCE_EXECUTION_STATISTIC_UPDATE = 'iuf.junia.event.post_performance_execution_statistic_update';

	/**
	 */
	const POST_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_UPDATE = 'iuf.junia.event.post_performance_music_and_timing_statistic_update';

	/**
	 */
	const POST_PERFORMANCE_TOTAL_STATISTIC_UPDATE = 'iuf.junia.event.post_performance_total_statistic_update';

	/**
	 */
	const POST_SAVE = 'iuf.junia.event.post_save';

	/**
	 */
	const POST_STARTGROUPS_ADD = 'iuf.junia.event.post_startgroups_add';

	/**
	 */
	const POST_STARTGROUPS_REMOVE = 'iuf.junia.event.post_startgroups_add';

	/**
	 */
	const POST_STARTGROUPS_UPDATE = 'iuf.junia.event.post_startgroups_update';

	/**
	 */
	const POST_UPDATE = 'iuf.junia.event.post_update';

	/**
	 */
	const PRE_CREATE = 'iuf.junia.event.pre_create';

	/**
	 */
	const PRE_DELETE = 'iuf.junia.event.pre_delete';

	/**
	 */
	const PRE_PERFORMANCE_CHOREOGRAPHY_STATISTIC_UPDATE = 'iuf.junia.event.pre_performance_choreography_statistic_update';

	/**
	 */
	const PRE_PERFORMANCE_EXECUTION_STATISTIC_UPDATE = 'iuf.junia.event.pre_performance_execution_statistic_update';

	/**
	 */
	const PRE_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_UPDATE = 'iuf.junia.event.pre_performance_music_and_timing_statistic_update';

	/**
	 */
	const PRE_PERFORMANCE_TOTAL_STATISTIC_UPDATE = 'iuf.junia.event.pre_performance_total_statistic_update';

	/**
	 */
	const PRE_SAVE = 'iuf.junia.event.pre_save';

	/**
	 */
	const PRE_STARTGROUPS_ADD = 'iuf.junia.event.pre_startgroups_add';

	/**
	 */
	const PRE_STARTGROUPS_REMOVE = 'iuf.junia.event.pre_startgroups_add';

	/**
	 */
	const PRE_STARTGROUPS_UPDATE = 'iuf.junia.event.pre_startgroups_update';

	/**
	 */
	const PRE_UPDATE = 'iuf.junia.event.pre_update';

	/**
	 */
	protected $event;

	/**
	 * @param Model $event
	 */
	public function __construct(Model $event) {
		$this->event = $event;
	}

	/**
	 * @return Event
	 */
	public function getEvent() {
		return $this->event;
	}
}

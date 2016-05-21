<?php
namespace iuf\junia\event;

use iuf\junia\model\Startgroup;
use Symfony\Component\EventDispatcher\Event;

/**
 */
class StartgroupEvent extends Event {

	/**
	 */
	const POST_COMPETITION_UPDATE = 'iuf.junia.startgroup.post_competition_update';

	/**
	 */
	const POST_CREATE = 'iuf.junia.startgroup.post_create';

	/**
	 */
	const POST_DELETE = 'iuf.junia.startgroup.post_delete';

	/**
	 */
	const POST_EVENT_UPDATE = 'iuf.junia.startgroup.post_event_update';

	/**
	 */
	const POST_JUDGES_ADD = 'iuf.junia.startgroup.post_judges_add';

	/**
	 */
	const POST_JUDGES_REMOVE = 'iuf.junia.startgroup.post_judges_add';

	/**
	 */
	const POST_JUDGES_UPDATE = 'iuf.junia.startgroup.post_judges_update';

	/**
	 */
	const POST_PERFORMANCE_CHOREOGRAPHY_STATISTIC_UPDATE = 'iuf.junia.startgroup.post_performance_choreography_statistic_update';

	/**
	 */
	const POST_PERFORMANCE_EXECUTION_STATISTIC_UPDATE = 'iuf.junia.startgroup.post_performance_execution_statistic_update';

	/**
	 */
	const POST_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_UPDATE = 'iuf.junia.startgroup.post_performance_music_and_timing_statistic_update';

	/**
	 */
	const POST_PERFORMANCE_TOTAL_STATISTIC_UPDATE = 'iuf.junia.startgroup.post_performance_total_statistic_update';

	/**
	 */
	const POST_ROUTINES_ADD = 'iuf.junia.startgroup.post_routines_add';

	/**
	 */
	const POST_ROUTINES_REMOVE = 'iuf.junia.startgroup.post_routines_add';

	/**
	 */
	const POST_ROUTINES_UPDATE = 'iuf.junia.startgroup.post_routines_update';

	/**
	 */
	const POST_SAVE = 'iuf.junia.startgroup.post_save';

	/**
	 */
	const POST_UPDATE = 'iuf.junia.startgroup.post_update';

	/**
	 */
	const PRE_COMPETITION_UPDATE = 'iuf.junia.startgroup.pre_competition_update';

	/**
	 */
	const PRE_CREATE = 'iuf.junia.startgroup.pre_create';

	/**
	 */
	const PRE_DELETE = 'iuf.junia.startgroup.pre_delete';

	/**
	 */
	const PRE_EVENT_UPDATE = 'iuf.junia.startgroup.pre_event_update';

	/**
	 */
	const PRE_JUDGES_ADD = 'iuf.junia.startgroup.pre_judges_add';

	/**
	 */
	const PRE_JUDGES_REMOVE = 'iuf.junia.startgroup.pre_judges_add';

	/**
	 */
	const PRE_JUDGES_UPDATE = 'iuf.junia.startgroup.pre_judges_update';

	/**
	 */
	const PRE_PERFORMANCE_CHOREOGRAPHY_STATISTIC_UPDATE = 'iuf.junia.startgroup.pre_performance_choreography_statistic_update';

	/**
	 */
	const PRE_PERFORMANCE_EXECUTION_STATISTIC_UPDATE = 'iuf.junia.startgroup.pre_performance_execution_statistic_update';

	/**
	 */
	const PRE_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_UPDATE = 'iuf.junia.startgroup.pre_performance_music_and_timing_statistic_update';

	/**
	 */
	const PRE_PERFORMANCE_TOTAL_STATISTIC_UPDATE = 'iuf.junia.startgroup.pre_performance_total_statistic_update';

	/**
	 */
	const PRE_ROUTINES_ADD = 'iuf.junia.startgroup.pre_routines_add';

	/**
	 */
	const PRE_ROUTINES_REMOVE = 'iuf.junia.startgroup.pre_routines_add';

	/**
	 */
	const PRE_ROUTINES_UPDATE = 'iuf.junia.startgroup.pre_routines_update';

	/**
	 */
	const PRE_SAVE = 'iuf.junia.startgroup.pre_save';

	/**
	 */
	const PRE_UPDATE = 'iuf.junia.startgroup.pre_update';

	/**
	 */
	protected $startgroup;

	/**
	 * @param Startgroup $startgroup
	 */
	public function __construct(Startgroup $startgroup) {
		$this->startgroup = $startgroup;
	}

	/**
	 * @return Startgroup
	 */
	public function getStartgroup() {
		return $this->startgroup;
	}
}

<?php
namespace iuf\junia\event;

use iuf\junia\model\Routine;
use Symfony\Component\EventDispatcher\Event;

/**
 */
class RoutineEvent extends Event {

	/**
	 */
	const POST_CREATE = 'iuf.junia.routine.post_create';

	/**
	 */
	const POST_DELETE = 'iuf.junia.routine.post_delete';

	/**
	 */
	const POST_PERFORMANCE_CHOREOGRAPHY_STATISTIC_UPDATE = 'iuf.junia.routine.post_performance_choreography_statistic_update';

	/**
	 */
	const POST_PERFORMANCE_EXECUTION_STATISTIC_UPDATE = 'iuf.junia.routine.post_performance_execution_statistic_update';

	/**
	 */
	const POST_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_UPDATE = 'iuf.junia.routine.post_performance_music_and_timing_statistic_update';

	/**
	 */
	const POST_PERFORMANCE_SCORES_ADD = 'iuf.junia.routine.post_performance_scores_add';

	/**
	 */
	const POST_PERFORMANCE_SCORES_REMOVE = 'iuf.junia.routine.post_performance_scores_add';

	/**
	 */
	const POST_PERFORMANCE_SCORES_UPDATE = 'iuf.junia.routine.post_performance_scores_update';

	/**
	 */
	const POST_PERFORMANCE_TOTAL_STATISTIC_UPDATE = 'iuf.junia.routine.post_performance_total_statistic_update';

	/**
	 */
	const POST_SAVE = 'iuf.junia.routine.post_save';

	/**
	 */
	const POST_STARTGROUP_UPDATE = 'iuf.junia.routine.post_startgroup_update';

	/**
	 */
	const POST_UPDATE = 'iuf.junia.routine.post_update';

	/**
	 */
	const PRE_CREATE = 'iuf.junia.routine.pre_create';

	/**
	 */
	const PRE_DELETE = 'iuf.junia.routine.pre_delete';

	/**
	 */
	const PRE_PERFORMANCE_CHOREOGRAPHY_STATISTIC_UPDATE = 'iuf.junia.routine.pre_performance_choreography_statistic_update';

	/**
	 */
	const PRE_PERFORMANCE_EXECUTION_STATISTIC_UPDATE = 'iuf.junia.routine.pre_performance_execution_statistic_update';

	/**
	 */
	const PRE_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_UPDATE = 'iuf.junia.routine.pre_performance_music_and_timing_statistic_update';

	/**
	 */
	const PRE_PERFORMANCE_SCORES_ADD = 'iuf.junia.routine.pre_performance_scores_add';

	/**
	 */
	const PRE_PERFORMANCE_SCORES_REMOVE = 'iuf.junia.routine.pre_performance_scores_add';

	/**
	 */
	const PRE_PERFORMANCE_SCORES_UPDATE = 'iuf.junia.routine.pre_performance_scores_update';

	/**
	 */
	const PRE_PERFORMANCE_TOTAL_STATISTIC_UPDATE = 'iuf.junia.routine.pre_performance_total_statistic_update';

	/**
	 */
	const PRE_SAVE = 'iuf.junia.routine.pre_save';

	/**
	 */
	const PRE_STARTGROUP_UPDATE = 'iuf.junia.routine.pre_startgroup_update';

	/**
	 */
	const PRE_UPDATE = 'iuf.junia.routine.pre_update';

	/**
	 */
	protected $routine;

	/**
	 * @param Routine $routine
	 */
	public function __construct(Routine $routine) {
		$this->routine = $routine;
	}

	/**
	 * @return Routine
	 */
	public function getRoutine() {
		return $this->routine;
	}
}

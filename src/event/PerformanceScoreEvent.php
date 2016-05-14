<?php
namespace iuf\junia\event;

use iuf\junia\model\PerformanceScore;
use Symfony\Component\EventDispatcher\Event;

/**
 */
class PerformanceScoreEvent extends Event {

	/**
	 */
	const POST_CREATE = 'iuf.junia.performance_score.post_create';

	/**
	 */
	const POST_DELETE = 'iuf.junia.performance_score.post_delete';

	/**
	 */
	const POST_JUDGE_UPDATE = 'iuf.junia.performance_score.post_judge_update';

	/**
	 */
	const POST_ROUTINE_UPDATE = 'iuf.junia.performance_score.post_routine_update';

	/**
	 */
	const POST_SAVE = 'iuf.junia.performance_score.post_save';

	/**
	 */
	const POST_UPDATE = 'iuf.junia.performance_score.post_update';

	/**
	 */
	const PRE_CREATE = 'iuf.junia.performance_score.pre_create';

	/**
	 */
	const PRE_DELETE = 'iuf.junia.performance_score.pre_delete';

	/**
	 */
	const PRE_JUDGE_UPDATE = 'iuf.junia.performance_score.pre_judge_update';

	/**
	 */
	const PRE_ROUTINE_UPDATE = 'iuf.junia.performance_score.pre_routine_update';

	/**
	 */
	const PRE_SAVE = 'iuf.junia.performance_score.pre_save';

	/**
	 */
	const PRE_UPDATE = 'iuf.junia.performance_score.pre_update';

	/**
	 */
	protected $performanceScore;

	/**
	 * @param PerformanceScore $performanceScore
	 */
	public function __construct(PerformanceScore $performanceScore) {
		$this->performanceScore = $performanceScore;
	}

	/**
	 * @return PerformanceScore
	 */
	public function getPerformanceScore() {
		return $this->performanceScore;
	}
}

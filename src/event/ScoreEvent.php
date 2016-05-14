<?php
namespace iuf\junia\event;

use iuf\junia\model\Score;
use Symfony\Component\EventDispatcher\Event;

/**
 */
class ScoreEvent extends Event {

	/**
	 */
	const POST_CREATE = 'iuf.junia.score.post_create';

	/**
	 */
	const POST_DELETE = 'iuf.junia.score.post_delete';

	/**
	 */
	const POST_JUDGE_UPDATE = 'iuf.junia.score.post_judge_update';

	/**
	 */
	const POST_ROUTINE_UPDATE = 'iuf.junia.score.post_routine_update';

	/**
	 */
	const POST_SAVE = 'iuf.junia.score.post_save';

	/**
	 */
	const POST_UPDATE = 'iuf.junia.score.post_update';

	/**
	 */
	const PRE_CREATE = 'iuf.junia.score.pre_create';

	/**
	 */
	const PRE_DELETE = 'iuf.junia.score.pre_delete';

	/**
	 */
	const PRE_JUDGE_UPDATE = 'iuf.junia.score.pre_judge_update';

	/**
	 */
	const PRE_ROUTINE_UPDATE = 'iuf.junia.score.pre_routine_update';

	/**
	 */
	const PRE_SAVE = 'iuf.junia.score.pre_save';

	/**
	 */
	const PRE_UPDATE = 'iuf.junia.score.pre_update';

	/**
	 */
	protected $score;

	/**
	 * @param Score $score
	 */
	public function __construct(Score $score) {
		$this->score = $score;
	}

	/**
	 * @return Score
	 */
	public function getScore() {
		return $this->score;
	}
}

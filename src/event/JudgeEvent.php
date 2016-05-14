<?php
namespace iuf\junia\event;

use iuf\junia\model\Judge;
use Symfony\Component\EventDispatcher\Event;

/**
 */
class JudgeEvent extends Event {

	/**
	 */
	const POST_CREATE = 'iuf.junia.judge.post_create';

	/**
	 */
	const POST_DELETE = 'iuf.junia.judge.post_delete';

	/**
	 */
	const POST_SAVE = 'iuf.junia.judge.post_save';

	/**
	 */
	const POST_STARTGROUP_UPDATE = 'iuf.junia.judge.post_startgroup_update';

	/**
	 */
	const POST_UPDATE = 'iuf.junia.judge.post_update';

	/**
	 */
	const POST_USER_UPDATE = 'iuf.junia.judge.post_user_update';

	/**
	 */
	const PRE_CREATE = 'iuf.junia.judge.pre_create';

	/**
	 */
	const PRE_DELETE = 'iuf.junia.judge.pre_delete';

	/**
	 */
	const PRE_SAVE = 'iuf.junia.judge.pre_save';

	/**
	 */
	const PRE_STARTGROUP_UPDATE = 'iuf.junia.judge.pre_startgroup_update';

	/**
	 */
	const PRE_UPDATE = 'iuf.junia.judge.pre_update';

	/**
	 */
	const PRE_USER_UPDATE = 'iuf.junia.judge.pre_user_update';

	/**
	 */
	protected $judge;

	/**
	 * @param Judge $judge
	 */
	public function __construct(Judge $judge) {
		$this->judge = $judge;
	}

	/**
	 * @return Judge
	 */
	public function getJudge() {
		return $this->judge;
	}
}

<?php
namespace iuf\junia\event;

use iuf\junia\model\Competition;
use Symfony\Component\EventDispatcher\Event;

/**
 */
class CompetitionEvent extends Event {

	/**
	 */
	const POST_CREATE = 'iuf.junia.competition.post_create';

	/**
	 */
	const POST_DELETE = 'iuf.junia.competition.post_delete';

	/**
	 */
	const POST_SAVE = 'iuf.junia.competition.post_save';

	/**
	 */
	const POST_STARTGROUPS_ADD = 'iuf.junia.competition.post_startgroups_add';

	/**
	 */
	const POST_STARTGROUPS_REMOVE = 'iuf.junia.competition.post_startgroups_add';

	/**
	 */
	const POST_STARTGROUPS_UPDATE = 'iuf.junia.competition.post_startgroups_update';

	/**
	 */
	const POST_UPDATE = 'iuf.junia.competition.post_update';

	/**
	 */
	const PRE_CREATE = 'iuf.junia.competition.pre_create';

	/**
	 */
	const PRE_DELETE = 'iuf.junia.competition.pre_delete';

	/**
	 */
	const PRE_SAVE = 'iuf.junia.competition.pre_save';

	/**
	 */
	const PRE_STARTGROUPS_ADD = 'iuf.junia.competition.pre_startgroups_add';

	/**
	 */
	const PRE_STARTGROUPS_REMOVE = 'iuf.junia.competition.pre_startgroups_add';

	/**
	 */
	const PRE_STARTGROUPS_UPDATE = 'iuf.junia.competition.pre_startgroups_update';

	/**
	 */
	const PRE_UPDATE = 'iuf.junia.competition.pre_update';

	/**
	 */
	protected $competition;

	/**
	 * @param Competition $competition
	 */
	public function __construct(Competition $competition) {
		$this->competition = $competition;
	}

	/**
	 * @return Competition
	 */
	public function getCompetition() {
		return $this->competition;
	}
}

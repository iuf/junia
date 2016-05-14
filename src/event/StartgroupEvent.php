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
<?php
namespace iuf\junia\event;

use iuf\junia\model\PerformanceStatistics;
use Symfony\Component\EventDispatcher\Event;

/**
 */
class PerformanceStatisticsEvent extends Event {

	/**
	 */
	const POST_CREATE = 'iuf.junia.performance_statistics.post_create';

	/**
	 */
	const POST_DELETE = 'iuf.junia.performance_statistics.post_delete';

	/**
	 */
	const POST_SAVE = 'iuf.junia.performance_statistics.post_save';

	/**
	 */
	const POST_UPDATE = 'iuf.junia.performance_statistics.post_update';

	/**
	 */
	const PRE_CREATE = 'iuf.junia.performance_statistics.pre_create';

	/**
	 */
	const PRE_DELETE = 'iuf.junia.performance_statistics.pre_delete';

	/**
	 */
	const PRE_SAVE = 'iuf.junia.performance_statistics.pre_save';

	/**
	 */
	const PRE_UPDATE = 'iuf.junia.performance_statistics.pre_update';

	/**
	 */
	protected $performanceStatistics;

	/**
	 * @param PerformanceStatistics $performanceStatistics
	 */
	public function __construct(PerformanceStatistics $performanceStatistics) {
		$this->performanceStatistics = $performanceStatistics;
	}

	/**
	 * @return PerformanceStatistics
	 */
	public function getPerformanceStatistics() {
		return $this->performanceStatistics;
	}
}

<?php
namespace iuf\junia\model;

use iuf\junia\model\Base\PerformanceStatistic as BasePerformanceStatistic;
use iuf\junia\serializer\PerformanceStatisticSerializer;
use keeko\framework\model\ApiModelInterface;

/**
 * Skeleton subclass for representing a row from the 'kk_junia_performance_statistic' table.
 * 
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class PerformanceStatistic extends BasePerformanceStatistic implements ApiModelInterface {

	/**
	 */
	private static $serializer;

	/**
	 * @return PerformanceStatisticSerializer
	 */
	public static function getSerializer() {
		if (self::$serializer === null) {
			self::$serializer = new PerformanceStatisticSerializer();
		}

		return self::$serializer;
	}
}

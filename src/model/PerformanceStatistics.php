<?php
namespace iuf\junia\model;

use iuf\junia\model\Base\PerformanceStatistics as BasePerformanceStatistics;
use iuf\junia\serializer\PerformanceStatisticsSerializer;
use keeko\framework\model\ApiModelInterface;

/**
 * Skeleton subclass for representing a row from the 'kk_junia_performance_statistics' table.
 * 
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class PerformanceStatistics extends BasePerformanceStatistics implements ApiModelInterface {

	/**
	 */
	private static $serializer;

	/**
	 * @return PerformanceStatisticsSerializer
	 */
	public static function getSerializer() {
		if (self::$serializer === null) {
			self::$serializer = new PerformanceStatisticsSerializer();
		}

		return self::$serializer;
	}
}

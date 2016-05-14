<?php
namespace iuf\junia\model;

use iuf\junia\model\Base\PerformanceScore as BasePerformanceScore;
use iuf\junia\serializer\PerformanceScoreSerializer;
use keeko\framework\model\ApiModelInterface;

/**
 * Skeleton subclass for representing a row from the 'kk_junia_performance_score' table.
 * 
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class PerformanceScore extends BasePerformanceScore implements ApiModelInterface {

	/**
	 */
	private static $serializer;

	/**
	 * @return PerformanceScoreSerializer
	 */
	public static function getSerializer() {
		if (self::$serializer === null) {
			self::$serializer = new PerformanceScoreSerializer();
		}

		return self::$serializer;
	}
}

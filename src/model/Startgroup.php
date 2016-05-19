<?php
namespace iuf\junia\model;

use iuf\junia\model\Base\Startgroup as BaseStartgroup;
use iuf\junia\serializer\StartgroupSerializer;
use keeko\framework\model\ApiModelInterface;

/**
 * Skeleton subclass for representing a row from the 'kk_junia_startgroup' table.
 * 
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Startgroup extends BaseStartgroup implements ApiModelInterface {

	/**
	 */
	private static $serializer;

	/**
	 * @return StartgroupSerializer
	 */
	public static function getSerializer() {
		if (self::$serializer === null) {
			self::$serializer = new StartgroupSerializer();
		}

		return self::$serializer;
	}
}

<?php
namespace iuf\junia\model;

use iuf\junia\model\Base\Routine as BaseRoutine;
use iuf\junia\serializer\RoutineSerializer;
use keeko\framework\model\ApiModelInterface;

/**
 * Skeleton subclass for representing a row from the 'kk_junia_routine' table.
 * 
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Routine extends BaseRoutine implements ApiModelInterface {

	/**
	 */
	private static $serializer;

	/**
	 * @return RoutineSerializer
	 */
	public static function getSerializer() {
		if (self::$serializer === null) {
			self::$serializer = new RoutineSerializer();
		}

		return self::$serializer;
	}
}

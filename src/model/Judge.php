<?php
namespace iuf\junia\model;

use iuf\junia\model\Base\Judge as BaseJudge;
use iuf\junia\serializer\JudgeSerializer;
use keeko\framework\model\ApiModelInterface;

/**
 * Skeleton subclass for representing a row from the 'kk_junia_judge' table.
 * 
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Judge extends BaseJudge implements ApiModelInterface {

	/**
	 */
	private static $serializer;

	/**
	 * @return JudgeSerializer
	 */
	public static function getSerializer() {
		if (self::$serializer === null) {
			self::$serializer = new JudgeSerializer();
		}

		return self::$serializer;
	}
}

<?php
namespace iuf\junia\model;

use iuf\junia\model\Base\Score as BaseScore;
use iuf\junia\serializer\ScoreSerializer;
use keeko\framework\model\ApiModelInterface;

/**
 * Skeleton subclass for representing a row from the 'kk_junia_score' table.
 * 
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Score extends BaseScore implements ApiModelInterface {

	/**
	 */
	private static $serializer;

	/**
	 * @return ScoreSerializer
	 */
	public static function getSerializer() {
		if (self::$serializer === null) {
			self::$serializer = new ScoreSerializer();
		}

		return self::$serializer;
	}
}

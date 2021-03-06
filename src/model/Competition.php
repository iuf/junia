<?php
namespace iuf\junia\model;

use iuf\junia\model\Base\Competition as BaseCompetition;
use iuf\junia\serializer\CompetitionSerializer;
use keeko\framework\model\ApiModelInterface;

/**
 * Skeleton subclass for representing a row from the 'kk_junia_competition' table.
 * 
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Competition extends BaseCompetition implements ApiModelInterface {

	/**
	 */
	private static $serializer;

	/**
	 * @return CompetitionSerializer
	 */
	public static function getSerializer() {
		if (self::$serializer === null) {
			self::$serializer = new CompetitionSerializer();
		}

		return self::$serializer;
	}
}

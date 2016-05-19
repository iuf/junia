<?php
namespace iuf\junia\model;

use iuf\junia\model\Base\Event as BaseEvent;
use iuf\junia\serializer\EventSerializer;
use keeko\framework\model\ApiModelInterface;

/**
 * Skeleton subclass for representing a row from the 'kk_junia_event' table.
 * 
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Event extends BaseEvent implements ApiModelInterface {

	/**
	 */
	private static $serializer;

	/**
	 * @return EventSerializer
	 */
	public static function getSerializer() {
		if (self::$serializer === null) {
			self::$serializer = new EventSerializer();
		}

		return self::$serializer;
	}
}

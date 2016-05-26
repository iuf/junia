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

	/**
	 * @return Judge
	 */
	public function getP1() {
		return $this->getPerformanceJudge(1);
	}

	/**
	 * @return Judge
	 */
	public function getP2() {
		return $this->getPerformanceJudge(2);
	}

	/**
	 * @return Judge
	 */
	public function getP3() {
		return $this->getPerformanceJudge(3);
	}

	/**
	 * @return Judge
	 */
	public function getP4() {
		return $this->getPerformanceJudge(4);
	}

	/**
	 * @return Judge
	 */
	public function getP5() {
		return $this->getPerformanceJudge(5);
	}

	/**
	 * @param mixed $position
	 */
	public function getPerformanceJudge($position) {
		$judges = $this->getJudges();
		foreach ($judges as $judge) {
		    if ($judge->getPosition() == 'P' . $position) {
		        return $judge;
		    }
		}
		$judge = new Judge();
		$judge->setPosition('P' . $position);
		$judge->setStartgroup($this);
		$judge->save();
		return $judge;
	}
}

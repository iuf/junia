<?php
namespace iuf\junia;

use keeko\framework\foundation\AbstractModule;
use iuf\junia\model\Competition;
use Propel\Runtime\Propel;

/**
 * Iuf Junia
 * 
 * @license MIT
 * @author gossi
 */
class JuniaModule extends AbstractModule {

	/**
	 */
	public function install() {
		// install sql
		$files = [
			'sql/keeko.sql',
			'data/static-data.sql'
		];
		
		try {
			$repo = $this->getServiceContainer()->getResourceRepository();
			$con = Propel::getConnection();
			foreach ($files as $file) {
				if ($repo->contains('/iuf/junia/database/' . $file)) {
					$sql = $repo->get('/iuf/junia/database/' . $file)->getBody();
					$stmt = $con->prepare($sql);
					$stmt->execute();
				}
			}
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
		
		// install static data
// 		$comp = new Competition();
// 		$comp->setLabel('Individual Freestyle');
// 		$comp->save();
		
// 		$comp = new Competition();
// 		$comp->setLabel('Pairs Freestyle');
// 		$comp->save();
		
// 		$comp = new Competition();
// 		$comp->setLabel('Small Group Freestyle');
// 		$comp->save();
		
// 		$comp = new Competition();
// 		$comp->setLabel('Large Group Freestyle');
// 		$comp->save();
	}

	/**
	 */
	public function uninstall() {
	}

	/**
	 * @param mixed $from
	 * @param mixed $to
	 */
	public function update($from, $to) {
	}
}

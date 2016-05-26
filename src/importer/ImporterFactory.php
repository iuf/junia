<?php
namespace iuf\junia\importer;

class ImporterFactory {
	
	/**
	 * 
	 * @param string $type
	 * @return ImporterInterface
	 */
	public static function generateImporter($type) {
		switch ($type) {
			case SchubertImporter::ID;
				return new SchubertImporter();
		}
	}
}
<?php
namespace iuf\junia\importer;

use iuf\junia\model\Event;

interface ImporterInterface {
	
	public function import($data, Event $event);
}
<?php
namespace iuf\junia\action;

use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use keeko\framework\utils\Parameters;
use iuf\junia\domain\EventDomain;

/**
 * List all events
 * 
 * This code is automatically created. Modifications will probably be overwritten.
 * 
 * @author gossi
 */
class EventListAction extends AbstractAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$params = new Parameters($request->query->all());
		$domain = new EventDomain($this->getServiceContainer());
		$payload = $domain->paginate($params);
		return $this->responder->run($request, $payload);
	}
}
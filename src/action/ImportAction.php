<?php
namespace iuf\junia\action;

use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Import data
 * 
 * This code is automatically created. Modifications will probably be overwritten.
 * 
 * @author gossi
 */
class ImportAction extends AbstractAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		return $this->responder->run($request);

		// alternatively:

		// 1) get data:
		// $data = Json::decode($request->getContent());
		//
		// -- or -- an id:
		// $id = $this->getParam('id');

		// 2) instantiate your domain
		// $domain = new YourDomain($this->getServiceContainer());

		// 3) run domain and store payload
		// $payload = $domain->yourMethod($id, $data);

		// 4) return response with payload
		// return $this->responder->run($request, $payload);
	}
}

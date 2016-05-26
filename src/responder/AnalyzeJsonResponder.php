<?php
namespace iuf\junia\responder;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use keeko\framework\foundation\AbstractPayloadResponder;
use keeko\framework\domain\payload\Success;
use keeko\framework\domain\payload\Failed;
use Symfony\Component\HttpFoundation\Response;

/**
 * Automatically generated JsonResponder for Analyze and create statistics on an event
 * 
 * @author gossi
 */
class AnalyzeJsonResponder extends AbstractPayloadResponder {

	/**
	 */
	protected function getPayloadMethods() {
		return [
			'keeko\framework\domain\payload\Failed' => 'failed',
			'keeko\framework\domain\payload\Success' => 'success'
		];
	}
	
	protected function success(Request $request, Success $payload) {
		return new JsonResponse(null, Response::HTTP_NO_CONTENT);
	}
	
	protected function failed(Request $request, Failed $payload) {
		throw $payload->get('exception');
	}
}

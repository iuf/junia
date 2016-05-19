<?php
namespace iuf\junia\action;

use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use phootwork\json\Json;
use Tobscure\JsonApi\Exception\InvalidParameterException;
use iuf\junia\domain\StartgroupDomain;

/**
 * Removes routine as relationship of startgroup
 * 
 * This code is automatically created. Modifications will probably be overwritten.
 * 
 * @author gossi
 */
class StartgroupRoutineRemoveAction extends AbstractAction {

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureParams(OptionsResolver $resolver) {
		$resolver->setRequired(['id']);
	}

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$body = Json::decode($request->getContent());
		if (!isset($body['data'])) {
			throw new InvalidParameterException();
		}
		$data = $body['data'];
		$id = $this->getParam('id');
		$domain = new StartgroupDomain($this->getServiceContainer());
		$payload = $domain->removeRoutine($id, $data);
		return $this->responder->run($request, $payload);
	}
}

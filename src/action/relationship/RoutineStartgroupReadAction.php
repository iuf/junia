<?php
namespace iuf\junia\action\relationship;

use iuf\junia\domain\RoutineDomain;
use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Reads the relationship of routine to startgroup
 * 
 * This code is automatically created. Modifications will probably be overwritten.
 * 
 * @author gossi
 */
class RoutineStartgroupReadAction extends AbstractAction {

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
		$id = $this->getParam('id');
		$domain = new RoutineDomain($this->getServiceContainer());
		$payload = $domain->read($id);
		return $this->responder->run($request, $payload);
	}
}

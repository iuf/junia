<?php
namespace iuf\junia\action;

use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use phootwork\json\Json;
use Tobscure\JsonApi\Exception\InvalidParameterException;
use iuf\junia\domain\RoutineDomain;

/**
 * Updates the relationship of routine to performance_choreography_statistic
 * 
 * This code is automatically created. Modifications will probably be overwritten.
 * 
 * @author gossi
 */
class RoutinePerformanceChoreographyStatisticUpdateAction extends AbstractAction {

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
		$domain = new RoutineDomain($this->getServiceContainer());
		$payload = $domain->setPerformanceChoreographyStatisticId($id, $data);
		return $this->responder->run($request, $payload);
	}
}
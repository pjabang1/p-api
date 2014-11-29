<?php

namespace Pension\FundBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListController extends Controller {


	/**
	 * 
	 * 
	 * 
	 */
	public function countriesAction() {
		$service = new \Pension\FundBundle\Service\ListService();
		$service->setConnection($this->get('database_connection'));

		return new JsonResponse($service->getCounries());
	}

	public function fundTypesAction() {
		$service = new \Pension\FundBundle\Service\ListService();
		$service->setConnection($this->get('database_connection'));

		return new JsonResponse($service->getFundTypes());
	}

	public function sectorsAction() {
		$service = new \Pension\FundBundle\Service\ListService();
		$service->setConnection($this->get('database_connection'));

		return new JsonResponse($service->getSectors());
	}

	public function fundCategoriesAction() {
		$service = new \Pension\FundBundle\Service\ListService();
		$service->setConnection($this->get('database_connection'));

		return new JsonResponse($service->getFundCategories());
	}

}

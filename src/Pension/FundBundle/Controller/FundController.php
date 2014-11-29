<?php

namespace Pension\FundBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class FundController extends Controller {

	public function indexAction() {
		$conn = $this->get('database_connection');
		$sql = 'SELECT pensionfunds.fondbolag,
    pensionfunds.fondnummer,
    pensionfunds.fondnamn,
    pensionfunds.valuta,
    pensionfunds.fondavgift,
    pensionfunds.tka,
    fundcategories.fundgroup,
    fundcategories.fondtyp,
    fundcategories.fundcatergory,
    pensionfunds.isin,
    pensionfunds.handel,
    pensionfunds.resultatberoende,
    pensionfunds.fondifond,
    pensionfunds.spread,
    pensionfunds."milj÷etisk",
    fifundholdingsheader.institutnr_fondbolag,
    fifundholdingsheader.firma_fondbolag,
    fifundholdingsheader.institutnr_fond,
    fifundholdingsheader.firma_fond,
    fifundholdingsheader.marknadsvarde_tot,
    fifundholdingsheader.fondformogenhet,
    fifundholdingsheader.andelsvarde,
    fifundholdingsdata.instrumentnamn,
    fifundholdingsdata.isin AS instrument_isin,
    fifundholdingsdata.land,
    countriesiso.iso3,
    countriesiso.countryname,
    countriesiso.country_number,
    fundsectors.sector,
    fifundholdingsdata.antal_instr,
    fifundholdingsdata.kurs_ranta,
    fifundholdingsdata.valutakurs,
    fifundholdingsdata.marknadsvarde,
    fifundholdingsdata.onoterad,
    fifundholdingsdata.inlanad_utlanad,
    fifundholdingsdata.marknadsvarde::double precision / fifundholdingsheader.marknadsvarde_tot::double precision AS holdingpercent
   FROM fundcategories
     JOIN (pensionfunds
     LEFT JOIN mappingfifundtoisin ON pensionfunds.isin::text = mappingfifundtoisin.isin::text) ON fundcategories.fondkategori::text = pensionfunds.fondkategori::text
     LEFT JOIN fifundholdingsheader ON mappingfifundtoisin.institutnr_fond = fifundholdingsheader.institutnr_fond
     LEFT JOIN fifundholdingsdata ON fifundholdingsheader.institutnr_fond = fifundholdingsdata.institutnr_fond
     LEFT JOIN countriesiso ON fifundholdingsdata.land::bpchar = countriesiso.code
     LEFT JOIN fundsectors ON fifundholdingsdata.isin::text = fundsectors.isin::text LIMIT 10';
		$funds = $conn->fetchAll($sql);
		return $this->render('PensionFundBundle:Default:index.html.twig', array('name' => ''));
	}

	/**
	 * 
	 * 
	 * 
	 */
	public function countriesAction() {
		$request = $this->getRequest();
		$fund = $request->query->get('fund');
		$service = new \Pension\FundBundle\Service\FundService();
		$service->setConnection($this->get('database_connection'));

		return new JsonResponse($service->getCountries($fund));
	}

	/**
	 * 
	 * 
	 * Examples 613133, 577304, 291906 
	 */
	public function sectorsAction() {
		$request = $this->getRequest();
		$fund = $request->query->get('fund');
		$service = new \Pension\FundBundle\Service\FundService();
		$service->setConnection($this->get('database_connection'));

		return new JsonResponse($service->getSectors($fund));
	}

	/**
	 * 
	 * 
	 * Examples 613133, 577304, 291906 
	 */
	public function detailsAction() {
		$request = $this->getRequest();
		$fund = $request->query->get('fund');
		$service = new \Pension\FundBundle\Service\FundService();
		$service->setConnection($this->get('database_connection'));

		return new JsonResponse($service->getDetails($fund));
	}

	public function fundsAction() {
		$service = new \Pension\FundBundle\Service\FundService();
		$service->setConnection($this->get('database_connection'));

		return new JsonResponse($service->getFunds());
	}

	public function autocompleteAction() {
		$service = new \Pension\FundBundle\Service\FundService();
		$service->setConnection($this->get('database_connection'));

		return new JsonResponse($service->getAutocomplete());
	}

}

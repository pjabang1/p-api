<?php

namespace Pension\FundBundle\Service;


class FundService 
{
	
	/**
	 *
	 * @var \Doctrine\DBAL\Driver\Connection 
	 */
	protected $connection;
	
	/**
	 * 
	 * @return \Doctrine\DBAL\Driver\Connection
	 */
	public function getConnection() {
		return $this->connection;
	}

	/**
	 * 
	 * @param \Doctrine\DBAL\Driver\Connection $connection
	 * @return \Pension\FundBundle\Service\FundService
	 */
	public function setConnection(\Doctrine\DBAL\Driver\Connection$connection) {
		$this->connection = $connection;
		return $this;
	}
	
	/**
	 * 
	 * @param type $fund
	 */
	public function getFunds() {
		
		$sql = "SELECT * FROM pensionfunds";
		
		return $this->getConnection()->fetchAll($sql, array());
	}
	
		
	/**
	 * 
	 * @param type $fund
	 */
	public function getAutocomplete() {
		
		$sql = "SELECT fondnamn FROM pensionfunds";
		
		return $this->getConnection()->fetchAll($sql, array());
	}
	
	
	/**
	 * 
	 * @param type $fund
	 */
	public function getCountries($fund) {
		
		$sql = "SELECT ppmfunddetailswithsectors.isin,
    ppmfunddetailswithsectors.fondnummer,
    ppmfunddetailswithsectors.fondnamn,
    ppmfunddetailswithsectors.valuta,
    ppmfunddetailswithsectors.iso3,
    ppmfunddetailswithsectors.countryname,
    ppmfunddetailswithsectors.country_number,
    sum(ppmfunddetailswithsectors.holdingpercent) AS holdingpercent
   FROM ppmfunddetailswithsectors 
   WHERE ppmfunddetailswithsectors.fondnummer = ?
  GROUP BY ppmfunddetailswithsectors.isin, ppmfunddetailswithsectors.fondnummer, ppmfunddetailswithsectors.fondnamn, ppmfunddetailswithsectors.valuta, ppmfunddetailswithsectors.iso3, ppmfunddetailswithsectors.countryname, ppmfunddetailswithsectors.country_number";
		
		return $this->getConnection()->fetchAll($sql, array($fund));
	}
	
	/**
	 * 
	 * @param type $fund
	 */
	public function getSectors($fund) {
				$sql = "SELECT ppmfunddetailswithsectors.isin,
    ppmfunddetailswithsectors.fondnummer,
    ppmfunddetailswithsectors.fondnamn,
    ppmfunddetailswithsectors.valuta,
    ppmfunddetailswithsectors.sector,
    sum(ppmfunddetailswithsectors.holdingpercent) AS holdingpercent
   FROM ppmfunddetailswithsectors WHERE ppmfunddetailswithsectors.fondnummer = ? 
  GROUP BY ppmfunddetailswithsectors.isin, ppmfunddetailswithsectors.fondnummer, ppmfunddetailswithsectors.fondnamn, ppmfunddetailswithsectors.valuta, ppmfunddetailswithsectors.sector";
		
		return $this->getConnection()->fetchAll($sql, array($fund));
		
	}
	
	/**
	 * 
	 * @param type $fund
	 */
	public function getDetails($fund) {
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
     LEFT JOIN fundsectors ON fifundholdingsdata.isin::text = fundsectors.isin::text 
	 WHERE pensionfunds.fondnummer = ?';
		
		return $this->getConnection()->fetchAll($sql, array($fund));
		
	}
	
	


	
}


<?php

namespace Pension\FundBundle\Service;


class ListService 
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
	 * 
	 */
	public function getCounries() {
		
		$sql = "SELECT * FROM countriesiso";
		
		return $this->getConnection()->fetchAll($sql, array());
	}
	
	/**
	 * 
	 * @return type
	 */
	public function getSectors() {
		
		$sql = "SELECT distinct(sector) AS sector FROM fundsectors";
		
		return $this->getConnection()->fetchAll($sql, array());
	}
	
	/**
	 * 
	 * @return type
	 */
	public function getFundTypes() {
		
		$sql = "SELECT distinct(fundtype) AS type FROM fundcategories";
		
		return $this->getConnection()->fetchAll($sql, array());
	}
	
		/**
	 * 
	 * @return type
	 */
	public function getFundCategories() {
		
		$sql = "SELECT distinct(fundcatergory) AS category FROM fundcategories";
		
		return $this->getConnection()->fetchAll($sql, array());
	}
		


	
}


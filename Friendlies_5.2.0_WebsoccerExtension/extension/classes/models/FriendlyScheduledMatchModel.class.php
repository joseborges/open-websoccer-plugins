<?php
/******************************************************

  Friendly module for HSE WebSoccer-Sim

  Copyright (c) 2013 by

  Pierre Keutel
  EMail: pierre.keutel@yahoo.fr
  Homepage: 
  
  Version: 1.0

******************************************************/

/**
 * @author Pierre Keutel
 */
class FriendlyScheduledMatchModel implements IModel {
	private $_db;
	private $_i18n;
	private $_websoccer;
	private $_teamId;
	
	public function __construct($db, $i18n, $websoccer) {
		$this->_db = $db;
		$this->_i18n = $i18n;
		$this->_websoccer = $websoccer;
	}
	
	public function renderView() {
		return ($this->_websoccer->getConfig("friendlies_on_off") == 1);
	}
	
	public function getTemplateParameters() {

		$matches = array();
		$paginator = null;
		
		$count = FriendliesDataService::countTodaysFriendlyMatches($this->_websoccer, $this->_db);
		
		if ($count) {
			$eps = $this->_websoccer->getConfig("entries_per_page");
			$paginator = new Paginator($count, $eps, $this->_websoccer);
			
			$matches = FriendliesDataService::getTodaysFriendlyMatches($this->_websoccer, $this->_db, $paginator->getFirstIndex(), $eps);
		}
		
		return array("matches" => $matches, "paginator" => $paginator);
	}
}

?>
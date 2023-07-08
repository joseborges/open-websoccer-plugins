<?php
/******************************************************

  Liveticker module for HSE WebSoccer-Sim

  Copyright (c) 2014 by

  Pierre Keutel
  EMail: pierre.keutel@yahoo.fr
  Homepage: sleepingpanda.info
  
  Version: 5.1.1

******************************************************/

/**
 * @author Pierre Keutel
 */
class AllLiveMatchesBlockModel implements IModel {
	private $_db;
	private $_i18n;
	private $_websoccer;
	private $_match;
	
	public function __construct($db, $i18n, $websoccer) {
		$this->_db = $db;
		$this->_i18n = $i18n;
		$this->_websoccer = $websoccer;
	}
	
	public function renderView() {
		$this->_match = LiveMatchesDataService::getLiveMatches($this->_websoccer, $this->_db);
		return (count($this->_match));
	}
	
	public function getTemplateParameters() {
		return array("matches" => $this->_match);
	}
	
}

?>
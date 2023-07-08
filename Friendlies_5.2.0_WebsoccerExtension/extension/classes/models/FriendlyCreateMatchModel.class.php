<?php
/******************************************************

  Friendly module for HSE WebSoccer-Sim

  Copyright (c) 2013 by

  Pierre Keutel
  EMail: pierre.keutel@yahoo.fr
  Homepage: 
  
  Version: 5.1.1

******************************************************/

/**
 * @author Pierre Keutel
 */
class FriendlyCreateMatchModel implements IModel {
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
		
		$myNationalTeamId = NationalteamsDataService::getNationalTeamManagedByCurrentUser($this->_websoccer, $this->_db);
		$nationalTeam = TeamsDataService::getTeamById($this->_websoccer, $this->_db, $myNationalTeamId);
		
		return array("nationalteam" => $nationalTeam);
	}
}

?>
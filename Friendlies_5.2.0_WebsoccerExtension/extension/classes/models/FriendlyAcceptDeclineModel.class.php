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
class FriendlyAcceptDeclineModel implements IModel {
	private $_db;
	private $_i18n;
	private $_websoccer;
	
	public function __construct($db, $i18n, $websoccer) {
		$this->_db = $db;
		$this->_i18n = $i18n;
		$this->_websoccer = $websoccer;
	}
	
	public function renderView() {
		return ($this->_websoccer->getConfig("friendlies_on_off") == 1);
	}
	
	public function getTemplateParameters() {
	
		$user = $this->_websoccer->getUser();
		$username = $user->username;
		$teamId = $user->getClubId($this->_websoccer, $this->_db);
		$matchId = (int) $this->_websoccer->getRequestParameter("id");
		
		$myTeam = TeamsDataService::getTeamById($this->_websoccer, $this->_db, $teamId);
		
		$matches = array();
		
		$count = FriendliesDataService::getFriendlyMatchById($this->_websoccer, $this->_db, $matchId, $user);
		
		if ($count) {
			$matches = FriendliesDataService::getFriendlyMatchById($this->_websoccer, $this->_db, $matchId, $user);
		}

		return array("matches" => $matches);
	}
	
}

?>

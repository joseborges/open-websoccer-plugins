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
class FriendlyOpenMatchModel implements IModel {
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
		
		$myTeam = TeamsDataService::getTeamById($this->_websoccer, $this->_db, $teamId);
		
		//select national team
		$nationalTeamId = FriendliesDataService::getNationalTeamManagedByUserId($this->_websoccer, $this->_db, $user->id);
		
		$matches = array();
		$paginator = null;
		$accept = array();
		
		$count = FriendliesDataService::countAllMyOpenFriendlyMatches($this->_websoccer, $this->_db, $user);
		
		if ($count) {
			
			FriendliesDataService::deleteOldFriendlyRequests($this->_websoccer, $this->_db, $teamId);
		
			$eps = $this->_websoccer->getConfig("entries_per_page");
			$paginator = new Paginator($count, $eps, $this->_websoccer);
			
			//$matches = FriendliesDataService::getMyOpenFriendlyMatches($this->_websoccer, $this->_db, $paginator->getFirstIndex(), $eps, $teamId);
			$matches = FriendliesDataService::getAllMyOpenFriendlyMatches($this->_websoccer, $this->_db, $paginator->getFirstIndex(), $eps, $user);
		}
		
		return array("matches" => $matches, "paginator" => $paginator, "myTeam" => $teamId, "myNationalTeam" => $nationalTeamId);
	}
	
}

?>
<?php
/******************************************************

  Fairplay module for HSE WebSoccer-Sim

  Copyright (c) 2013 by

  Pierre Keutel
  EMail: pierre.keutel@yahoo.fr
  Homepage: 
  
  Version: 1.0

******************************************************/

/**
 * @author Pierre Keutel
 */
 
 class FairplayModel implements IModel {
	private $_db;
	private $_i18n;
	private $_websoccer;
	
	public function __construct($db, $i18n, $websoccer) {
		$this->_db = $db;
		$this->_i18n = $i18n;
		$this->_websoccer = $websoccer;
	}
	
	public function renderView() {
		return TRUE;
	}
	
	public function getTemplateParameters() {
		
		$user = $this->_websoccer->getUser();

		$teamId = $user->getClubId($this->_websoccer, $this->_db);
		
		$myTeam = TeamsDataService::getTeamById($this->_websoccer, $this->_db, $teamId);
		
		$league = $myTeam['team_league_id'];
		
		if($this->_websoccer->getRequestParameter("leagueid"))
			$league_id = $this->_websoccer->getRequestParameter("leagueid");
		else {
			if($league)
				$league_id = $league;
			else $league_id = 1;
		}
		
		return	array("teams" => FairplayDataService::getFairplayTable($this->_websoccer, $this->_db, null, $league_id),
						"leagues" => LeagueDataService::getLeaguesSortedByCountry($this->_websoccer, $this->_db));
	}
	
}

?>
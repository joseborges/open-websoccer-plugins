<?php
/******************************************************

  Friendly module for HSE WebSoccer-Sim

  Copyright (c) 2014 by

  Pierre Keutel
  EMail: pierre.keutel@yahoo.fr
  Homepage: 

  Version: 5.2.0
  
******************************************************/

/**
 * @author Pierre Keutel
 */
class FriendlyController implements IActionController {
	private $_i18n;
	private $_websoccer;
	private $_db;
	
	public function __construct(I18n $i18n, WebSoccer $websoccer, DbConnection $db) {
		$this->_i18n = $i18n;
		$this->_websoccer = $websoccer;
		$this->_db = $db;
	}
	
	public function executeAction($parameters) {
		
		// check if feature is enabled
		if (!$this->_websoccer->getConfig("friendlies_on_off")) {
			return NULL;
		}
		
		$user = $this->_websoccer->getUser();
		$username = $user->username;
		$teamId = $user->getClubId($this->_websoccer, $this->_db);
		
		$myTeam = TeamsDataService::getTeamById($this->_websoccer, $this->_db, $teamId);
		$myNationalTeamId = NationalteamsDataService::getNationalTeamManagedByCurrentUser($this->_websoccer, $this->_db);
		$myNationalTeam = TeamsDataService::getTeamById($this->_websoccer, $this->_db, $myNationalTeamId);
		
		$opponent = $parameters["friendlyopponent"];
		$opponentId = FriendliesDataService::getTeamIdByName($this->_websoccer, $this->_db, $opponent);
		
		$date = $parameters["friendlydp_date"];
		$time = $parameters["friendlydp_time"];
		
		//actual timestamp
		$now = $this->_websoccer->getNowAsTimestamp();
		//format given date to timestamp
		$data = $parameters["friendlydp_date"]." ".$parameters["friendlydp_time"];
		$fsDate = DateTime::createFromFormat("d.m.Y H:i", $data);
		$fsTimestamp = $fsDate->getTimestamp();
		$fsTimeDiff = $this->_websoccer->getConfig("friendlies_time_difference");
		$fsTimeDiffValue = ($fsTimeDiff*60);
		//verify time of 'set' friendly with actual time
		if ($fsTimestamp < ($now + $fsTimeDiffValue)) {
			throw new Exception($this->_i18n->getMessage("friendly_schedule_err_timestamp", $fsTimeDiff));
		}
		
		$year = date('Y', $fsTimestamp); 
		$month = date('n', $fsTimestamp); 
		$day = date('j', $fsTimestamp); 
		
		//verify number of friendlies available
		$possibleFS = $this->_websoccer->getConfig("friendlies_per_day");
		$ownFS = FriendliesDataService::countFriendlyMatches($this->_websoccer, $this->_db, $teamId, $day, $month, $year);
		$ownTmpFS = FriendliesDataService::countTmpFriendlyMatches($this->_websoccer, $this->_db, $teamId);
		$opponentFS = FriendliesDataService::countFriendlyMatches($this->_websoccer, $this->_db, $opponentId, $day, $month, $year);
		$opponentTmpFS = FriendliesDataService::countTmpFriendlyMatches($this->_websoccer, $this->_db, $opponentId);
		$opponentType = FriendliesDataService::checkIfNationalteam($this->_websoccer, $this->_db, $opponent);
		
		$myFS = $ownFS + $ownTmpFS;
		$rivalFS = $opponentFS + $opponentTmpFS;
	
		if($myFS >= $possibleFS) {
			throw new Exception($this->_i18n->getMessage("friendly_schedule_err_own_fs", $this->_websoccer->getConfig("friendlies_per_day")));
		}
		if($rivalFS >= $possibleFS) {
			throw new Exception($this->_i18n->getMessage("friendly_schedule_err_opponent_fs", $this->_websoccer->getConfig("friendlies_per_day")));
		}
		/* START NATIONALTEAM */
		if($opponentType && !$parameters["friendlynationalteam"]) {
			throw new Exception($this->_i18n->getMessage("friendly_schedule_err_opponent_nationalteam", $opponent));
		}
		if($parameters["friendlynationalteam"] && !$opponentType) {
			throw new Exception($this->_i18n->getMessage("friendly_schedule_err_opponent_not_valid", $opponent));
		}
		if($parameters["friendlynationalteam"] && ($myNationalTeamId == $opponentId)) {
			throw new Exception($this->_i18n->getMessage("friendly_schedule_err_opponent_own_nationalteam", $opponent));
		}
		/* END NATIONALTEAM */
		
		//check opponent for friendly (!own team && !team w/o manager)
		if($teamId == $opponentId) {
			throw new Exception($this->_i18n->getMessage("friendly_schedule_err_opponent_ownteam", $opponent));
		}
		$opponentTeam = TeamsDataService::getTeamSummaryById($this->_websoccer, $this->_db, $opponentId);
		if(empty($opponentTeam["user_id"])) {
			throw new Exception($this->_i18n->getMessage("friendly_schedule_err_opponent_nomanager", $opponent));
		}
		
		//get stadium of home team
		$stadium = StadiumsDataService::getStadiumByTeamId($this->_websoccer, $this->_db, $teamId);

		//insert friendly in tmp table
		$columns["spieltyp"] = "Freundschaft";
		$columns["datum"] = $fsTimestamp;
		$columns["stadion_id"] = $stadium["stadium_id"];
		//save nationalteam friendly
		if($parameters["friendlynationalteam"]) {
			$columns["home_verein"] = $myNationalTeamId;
		} else {
			$columns["home_verein"] = $teamId;
		}
		//end
		$columns["gast_verein"] = $opponentId;
		
		$fromTable = $this->_websoccer->getConfig("db_prefix") ."_friendly_tmp";
		$this->_db->queryInsert($columns, $fromTable);
		
		//prepare notification
		if($parameters["friendlynationalteam"]) { 
			$friendlyTeam = $myNationalTeam['team_name']; 
		} else { 
			$friendlyTeam = $myTeam['team_name']; 
		}
		//end

		// send notification to user
		NotificationsDataService::createNotification($this->_websoccer, $this->_db, $opponentTeam["user_id"], "friendly_matchrequest_notification",
			array("team" => $friendlyTeam, 
				"date" => $this->_websoccer->getFormattedDatetime($fsTimestamp)), "friendly-openmatches","friendly-openmatches");

		$str = "[".$date." - ".$time."] ".$friendlyTeam." vs. ".$opponent." (".$stadium["name"].")";
				
		$this->_websoccer->addFrontMessage(new FrontMessage(MESSAGE_TYPE_SUCCESS, 
				$this->_i18n->getMessage("friendly-match_invitation_send",$str)));
		
		return "friendly-matchset";
	}
	
}

?>
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
class FriendlyAcceptDeclineController implements IActionController {
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
			return;
		}
		
		$user = $this->_websoccer->getUser();
		$teamId = $user->getClubId($this->_websoccer, $this->_db);
		$myTeam = TeamsDataService::getTeamById($this->_websoccer, $this->_db, $teamId);
		$myNationalTeamId = NationalteamsDataService::getNationalTeamManagedByCurrentUser($this->_websoccer, $this->_db);
		$myNationalTeam = TeamsDataService::getTeamById($this->_websoccer, $this->_db, $myNationalTeamId);
		
		//get necessary params
		$matchId = $parameters["id"];
		$action = $parameters["action"];
		
		$matches = array();
		//check for selected match
		$count = FriendliesDataService::getFriendlyMatchById($this->_websoccer, $this->_db, $matchId, $user);
		
		if ($count) {
			
			$matches = FriendliesDataService::getFriendlyMatchById($this->_websoccer, $this->_db, $matchId, $user);
			$matchInfo = call_user_func_array('array_merge', $matches);

			//if action is accepting the match
			if($action=="accept") {
				
				//insert accepted game in _spiel table
				$this->insertIntoMatchTable($matchInfo);
				//delete match from temporary table after insertion
				$this->deleteFromFriendlyTmpTable($matchId);
				
				// success message
				if ($myTeam['team_id'] == $matchInfo['home_id'] || $myNationalTeam['team_id'] == $matchInfo['home_id']) {
					$opponentTeam = TeamsDataService::getTeamById($this->_websoccer, $this->_db, $matchInfo['guest_id']);
					if($myTeam['team_id'] == $matchInfo['home_id']) {
						$team_name = $myTeam['team_name'];
					} else {
						$team_name = $myNationalTeam['team_name'];
					}
					$str = $team_name." vs. ".$opponentTeam['team_name'];
				 } else {
					$opponentTeam = TeamsDataService::getTeamById($this->_websoccer, $this->_db, $matchInfo['home_id']);
					if($myTeam['team_id'] == $matchInfo['guest_id']) {
						$team_name = $myTeam['team_name'];
					} else {
						$team_name = $myNationalTeam['team_name'];
					}
					$str = $opponentTeam['team_name']." vs. ".$team_name;
				}
					
				// send notification to user
				NotificationsDataService::createNotification($this->_websoccer, $this->_db, $opponentTeam["team_user_id"], "friendly_matchrequest_accept_notification",
				array("team" => $team_name, 
						"date" => $this->_websoccer->getFormattedDatetime($matchInfo['date'])), "friendly-accepted","friendly");

					
				//$str = $team_name." vs. ".$opponentTeam['team_name'];
				
                $this->_websoccer->addFrontMessage(new FrontMessage(MESSAGE_TYPE_SUCCESS,
                                $this->_i18n->getMessage("friendly_accept_success",$str)));
                                
				return "friendly-openmatches";
			}
			//if action is refusing/declining the match
			elseif($action=="decline") {

				//delete match from temporary table
				$this->deleteFromFriendlyTmpTable($matchId);
				//success message
				if ($myTeam['team_id'] == $matchInfo['home_id'] || $myNationalTeam['team_id'] == $matchInfo['home_id']) {
					$opponentTeam = TeamsDataService::getTeamById($this->_websoccer, $this->_db, $matchInfo['guest_id']);
					if($myTeam['team_id'] == $matchInfo['home_id']) {
						$team_name = $myTeam['team_name'];
					} else {
						$team_name = $myNationalTeam['team_name'];
					}
					$str = $team_name." vs. ".$opponentTeam['team_name'];
				}
				else {
					$opponentTeam = TeamsDataService::getTeamById($this->_websoccer, $this->_db, $matchInfo['home_id']);
					if($myTeam['team_id'] == $matchInfo['guest_id']) {
						$team_name = $myTeam['team_name'];
					} else {
						$team_name = $myNationalTeam['team_name'];
					}
					$str = $opponentTeam['team_name']." vs. ".$team_name;
				}
				
				// send notification to user
				NotificationsDataService::createNotification($this->_websoccer, $this->_db, $opponentTeam["team_user_id"], "friendly_matchrequest_decline_notification",
				array("team" => $team_name, 
						"date" => $this->_websoccer->getFormattedDatetime($matchInfo['date'])), "friendly-declined","friendly");
				
				$this->_websoccer->addFrontMessage(new FrontMessage(MESSAGE_TYPE_SUCCESS,
                                $this->_i18n->getMessage("friendly_decline_success",$str),
                                ""));
				return "friendly-openmatches";
			}
		}
	}
	
	//function to insert match after accept in "_spiel" table
	public function insertIntoMatchTable($matchInfo) {
		
		//insert friendly in tmp table
		$columns["spieltyp"] = "Freundschaft";
		$columns["datum"] = $matchInfo["date"];
		$columns["stadion_id"] = $matchInfo['stadium'];
		$columns["home_verein"] = $matchInfo['home_id'];
		$columns["gast_verein"] = $matchInfo['guest_id'];
		
		$fromTable = $this->_websoccer->getConfig("db_prefix") ."_spiel";
		
		$this->_db->queryInsert($columns, $fromTable);
	}
	
	public function deleteFromFriendlyTmpTable($match) {
	
		// delete
        $fromTable = $this->_websoccer->getConfig("db_prefix") . "_friendly_tmp";
        $whereCondition = "id = %d";
	
		$this->_db->queryDelete($fromTable, $whereCondition, $match);
	
	}
	
}

?>
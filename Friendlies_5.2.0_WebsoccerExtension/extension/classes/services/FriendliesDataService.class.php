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
 * Data service for friendly matches
 */
class FriendliesDataService {

	//check number of friendlies for today
	public static function countTodaysFriendlyMatches(WebSoccer $websoccer, DbConnection $db, $teamId) {
	
		$startTs = mktime (0, 0, 1, date("n"), date("j"), date("Y"));
		$endTs = $startTs + 3600 * 24;
	
		if($teamId != 0) {
			// where
			$whereCondition = "M.datum >= %d AND M.datum < %d AND M.spieltyp = 'Freundschaft' AND (home_verein = '".$teamId."' OR gast_verein = '".$teamId."')";
			$parameters = array($startTs, $endTs);
		}
		else {
			// where
			$whereCondition = "M.datum >= %d AND M.datum < %d AND M.spieltyp = 'Freundschaft'";
			$parameters = array($startTs, $endTs);
		}
		
		$result = $db->querySelect("COUNT(*) AS hits", $websoccer->getConfig("db_prefix") . "_spiel AS M", $whereCondition, $parameters);
		$matches = $result->fetch_array();
		$result->free();
		
		if ($matches) {
			return $matches["hits"];
		}
	
		return 0;
	}
	
	//check number of friendlies
	public static function countFriendlyMatches(WebSoccer $websoccer, DbConnection $db, $teamId, $day, $month, $year) {
	
		$startTs = mktime (0, 0, 1, $month, $day, $year);
		$endTs = $startTs + 3600 * 24;
	
		if($teamId != 0) {
			// where
			$whereCondition = "M.datum >= %d AND M.datum < %d AND M.spieltyp = 'Freundschaft' AND (home_verein = '".$teamId."' OR gast_verein = '".$teamId."')";
			$parameters = array($startTs, $endTs);
		}
		else {
			// where
			$whereCondition = "M.datum >= %d AND M.datum < %d AND M.spieltyp = 'Freundschaft'";
			$parameters = array($startTs, $endTs);
		}
		
		$result = $db->querySelect("COUNT(*) AS hits", $websoccer->getConfig("db_prefix") . "_spiel AS M", $whereCondition, $parameters);
		$matches = $result->fetch_array();
		$result->free();
		
		if ($matches) {
			return $matches["hits"];
		}
	
		return 0;
	}
	
	//check number of friendlies in temporary table
	public static function countTmpFriendlyMatches(WebSoccer $websoccer, DbConnection $db, $teamId) {

		// where
		$whereCondition = "home_verein = '".$teamId."' OR gast_verein = '".$teamId."'";
		
		$result = $db->querySelect("COUNT(*) AS hits", $websoccer->getConfig("db_prefix") . "_friendly_tmp AS F", $whereCondition);
		$fs_available = $result->fetch_array();
		$result->free();
		
		if($fs_available) {
			return (int) $fs_available["hits"];
		}
		return 0;
	}
	
	//check number of planned friendlies (not played)
	public static function countPlannedFriendlyMatches(WebSoccer $websoccer, DbConnection $db, $teamId) {
	
		$startTs = mktime (0, 0, 1, date("n"), date("j"), date("Y"));
	
		if($teamId != 0) {
			// where
			$whereCondition = "M.datum >= %d AND M.spieltyp = 'Freundschaft' AND (home_verein = '".$teamId."' OR gast_verein = '".$teamId."')";
			$parameters = array($startTs);
		}
		else {
			// where
			$whereCondition = "M.datum >= %d AND M.spieltyp = 'Freundschaft'";
			$parameters = array($startTs);
		}
		
		$result = $db->querySelect("COUNT(*) AS hits", $websoccer->getConfig("db_prefix") . "_spiel AS M", $whereCondition, $parameters);
		$matches = $result->fetch_array();
		$result->free();
		
		if ($matches) {
			return $matches["hits"];
		}
	
		return 0;
	}
	
	//get the friendly matches for today
	public static function getTodaysFriendlyMatches(WebSoccer $websoccer, DbConnection $db, $startIndex, $entries_per_page) {
		
		$startTs = mktime (0, 0, 1, date("n"), date("j"), date("Y"));
		$endTs = $startTs + 3600 * 24;
		
		// where
		$whereCondition = "M.datum >= %d AND M.datum < %d AND M.spieltyp = 'Freundschaft' ORDER BY M.datum ASC";
		$parameters = array($startTs, $endTs);
	
		$limit = $startIndex .",". $entries_per_page;
		return self::getMatchesByCondition($websoccer, $db, $whereCondition, $parameters, $limit);
	}
	
	//get all planned friendly matches
	public static function getPlannedFriendlyMatches(WebSoccer $websoccer, DbConnection $db, $startIndex, $entries_per_page) {
		
		$startTs = mktime (0, 0, 1, date("n"), date("j"), date("Y"));
		
		// where
		$whereCondition = "M.datum >= %d AND M.spieltyp = 'Freundschaft' ORDER BY M.datum ASC";
		$parameters = array($startTs);
	
		$limit = $startIndex .",". $entries_per_page;
		return self::getMatchesByCondition($websoccer, $db, $whereCondition, $parameters, $limit);
	}
	
	//get number of all my open friendly matches (national team + club team)
	public static function countAllMyOpenFriendlyMatches(WebSoccer $websoccer, DbConnection $db, $user) {
	
		//select club team
		$teamId = $user->getClubId($websoccer, $db);
		
		//select national team
		$nationalTeamId = self::getNationalTeamManagedByUserId($websoccer, $db, $user->id);
	
		// where
		$whereCondition = "M.spieltyp = 'Freundschaft' AND (M.home_verein = '".$teamId."' OR M.gast_verein = '".$teamId."' OR M.home_verein = '".$nationalTeamId."' OR M.gast_verein = '".$nationalTeamId."')";
		
		$result = $db->querySelect("COUNT(*) AS hits", $websoccer->getConfig("db_prefix") . "_friendly_tmp AS M", $whereCondition);
		$matches = $result->fetch_array();
		$result->free();
		
		if ($matches) {
			return $matches["hits"];
		}
	
		return 0;
	}

	//get friendly matches (info) of all my open friendlies (national team + club team)
	public static function getAllMyOpenFriendlyMatches(WebSoccer $websoccer, DbConnection $db, $startIndex, $entries_per_page, $user) {
		
		//select club team
		$teamId = $user->getClubId($websoccer, $db);
		//select national team
		$nationalTeamId = self::getNationalTeamManagedByUserId($websoccer, $db, $user->id);
	
		// where
		$whereCondition = "F.spieltyp = 'Freundschaft' AND (F.home_verein = '".$teamId."' OR F.gast_verein = '".$teamId."' OR F.home_verein = '".$nationalTeamId."' OR F.gast_verein = '".$nationalTeamId."') ORDER BY F.datum ASC";
		$parameters = "";
	
		$limit = $startIndex .",". $entries_per_page;
		return self::getOpenFriendlyMatchesByCondition($websoccer, $db, $whereCondition, $parameters, $limit);
	}
	
	public static function getNationalTeamManagedByUserId(WebSoccer $websoccer, DbConnection $db, $user) {
		
		$result = $db->queryCachedSelect("id", $websoccer->getConfig("db_prefix") . "_verein", 
				"user_id = %d AND nationalteam = '1'", $user, 1);
		if (count($result)) {
			return $result[0]["id"];
		}
		
		return NULL;
	}

	//including national teams
	public static function getFriendlyMatchById(WebSoccer $websoccer, DbConnection $db, $matchId, $user) {
		
		//select club team
		$teamId = $user->getClubId($websoccer, $db);
		//select national team
		$nationalTeamId = self::getNationalTeamManagedByUserId($websoccer, $db, $user->id);
		
		// where
		$whereCondition = "F.spieltyp = 'Freundschaft' AND F.id = '".$matchId."' AND (F.home_verein = '".$teamId."' OR F.gast_verein = '".$teamId."' OR F.home_verein = '".$nationalTeamId."' OR F.gast_verein = '".$nationalTeamId."')";
		$parameters = "";
		
		return self::getOpenFriendlyMatchesByCondition($websoccer, $db, $whereCondition, $parameters, $limit);	
	}
	
	private static function getOpenFriendlyMatchesByCondition(WebSoccer $websoccer, DbConnection $db, $whereCondition, $parameters, $limit) {
		$tablePrefix = $websoccer->getConfig("db_prefix");
		
		// from
		$fromTable = $tablePrefix . "_friendly_tmp AS F";
		$fromTable .= " INNER JOIN " . $tablePrefix . "_verein AS HOME ON F.home_verein = HOME.id";
		$fromTable .= " INNER JOIN " . $tablePrefix . "_verein AS GUEST ON F.gast_verein = GUEST.id";
		
		// select
		$columns["F.id"] = "id";
		$columns["HOME.name"] = "home_team";
		$columns["HOME.id"] = "home_id";
		$columns["GUEST.name"] = "guest_team";
		$columns["GUEST.id"] = "guest_id";
		$columns["F.datum"] = "date";
		$columns["F.stadion_id"] = "stadium";
		
		$matches = array();
		$result = $db->querySelect($columns, $fromTable, $whereCondition, $parameters, $limit);
		while ($matchinfo = $result->fetch_array()) {
			$matches[] = $matchinfo;
		}
		$result->free();
		return $matches;
	}
	
	private static function getMatchesByCondition(WebSoccer $websoccer, DbConnection $db, $whereCondition, $parameters, $limit) {
		$fromTable = self::_getFromPart($websoccer);
		
		// select
		$columns["M.id"] = "id";
	 	$columns["M.spieltyp"] = "type";
		$columns["HOME.name"] = "home_team";
		$columns["HOME.id"] = "home_id";
		$columns["GUEST.name"] = "guest_team";
		$columns["GUEST.id"] = "guest_id";
		$columns["M.home_tore"] = "home_goals";
		$columns["M.gast_tore"] = "guest_goals";
		$columns["M.berechnet"] = "simulated";
		$columns["M.minutes"] = "minutes";
		$columns["M.datum"] = "date";
		
		$matches = array();
		$result = $db->querySelect($columns, $fromTable, $whereCondition, $parameters, $limit);
		while ($matchinfo = $result->fetch_array()) {
			$matches[] = $matchinfo;
		}
		$result->free();
		return $matches;
	}
	
	public static function getTeamIdByName(WebSoccer $websoccer, DbConnection $db, $teamName) {
		$columns = "id";
		$fromTable = $websoccer->getConfig("db_prefix") . "_verein";
		$whereCondition = "UPPER(name) LIKE '%s%%' AND status = 1";
		
		$result = $db->querySelect($columns, $fromTable, $whereCondition, strtoupper($teamName));
		
		$teamId = $result->fetch_array();
		$result->free();
		
		return (int) $teamId["id"];
	}
	
	public static function checkIfNationalteam(WebSoccer $websoccer, DbConnection $db, $teamName) {
		$columns = "nationalteam";
		$fromTable = $websoccer->getConfig("db_prefix") . "_verein";
		$whereCondition = "UPPER(name) LIKE '%s%%' AND status = 1";
		
		$result = $db->querySelect($columns, $fromTable, $whereCondition, strtoupper($teamName));
		
		$teamId = $result->fetch_array();
		$result->free();
		
		return (int) $teamId["nationalteam"];
	}
	
	public static function deleteOldFriendlyRequests(WebSoccer $websoccer, DbConnection $db, $teamId) {
		
		$columns = "id";
		$fromTable = $websoccer->getConfig("db_prefix") . "_friendly_tmp";
		$whereCondition = "(home_verein = ".$teamId." OR gast_verein = ".$teamId.") AND datum <= UNIX_TIMESTAMP(NOW())";
		
		$result = $db->querySelect($columns, $fromTable, $whereCondition);
		
		while($oldFriendly = $result->fetch_array()) {
			// delete old friendly from tmp table
        	$fromTable = $websoccer->getConfig("db_prefix") . "_friendly_tmp";
        	$whereCondition = "id = ".$oldFriendly['id'];
        	
			$db->queryDelete($fromTable, $whereCondition);
		}
		$result->free();
		
		return 0;
		
	}
	
	private static function _getFromPart(WebSoccer $websoccer) {
		$tablePrefix = $websoccer->getConfig("db_prefix");
		
		// from
		$fromTable = $tablePrefix . "_spiel AS M";
		$fromTable .= " INNER JOIN " . $tablePrefix . "_verein AS HOME ON M.home_verein = HOME.id";
		$fromTable .= " INNER JOIN " . $tablePrefix . "_verein AS GUEST ON M.gast_verein = GUEST.id";
		return $fromTable;
	}
}
?>

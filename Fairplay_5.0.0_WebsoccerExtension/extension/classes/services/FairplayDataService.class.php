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
 * Data service for fairplay statistics
 */
class FairplayDataService {

	/**
	 * Provides teams ranked by number oof penalty points in the current season.
	 * 
	 * @param WebSoccer $websoccer Application context.
	 * @param DbConnection $db DB connection.
	 * @param int $limit Maximum number of teams to fetch.
	 * @param int|NULL $leagueId ID of league. If not provided, league of connected user will be returned.
	 * @return array list of found teams or empty array if no teams exist.
	 */
	public static function getFairplayTable(WebSoccer $websoccer, DbConnection $db, $limit = null, $leagueId = null) {
		$parameters = array();
		
		$columns["SUM(P.sa_karten_gelb)"] = "yellow_card";
		$columns["SUM(P.sa_karten_gelb_rot)"] = "yellow_red_card";
		$columns["SUM(P.sa_karten_rot)"] = "red_card";
		$columns["P.verein_id"] = "team_id";
		
		$columns["C.name"] = "team_name";
		$columns["C.bild"] = "picture";
		
		$columns["U.id"] = "user_id";
		$columns["U.nick"] = "user_name";
		$columns["U.email"] = "team_user_email";
		$columns["U.picture"] = "team_user_picture";
		
		$columns["(SUM(P.sa_karten_gelb)+SUM(P.sa_karten_gelb_rot)*3+SUM(P.sa_karten_rot)*5)"] = "points";
		
		$fromTable = $websoccer->getConfig("db_prefix") . "_spieler AS P";
		$fromTable .= " INNER JOIN " . $websoccer->getConfig("db_prefix") . "_verein AS C ON C.id = P.verein_id";
		$fromTable .= " LEFT JOIN " . $websoccer->getConfig("db_prefix") . "_user AS U ON U.id = C.user_id";
				
		if ($leagueId != null) {
			$whereCondition = " liga_id = %d";
			$parameters[] = (int) $leagueId;
		}
		$whereCondition .= " GROUP BY P.verein_id ORDER BY points ASC";
		
		$result = $db->querySelect($columns, $fromTable, $whereCondition, $parameters, $limit);
		
		$teams = array();
		while ($team = $result->fetch_array()) {
			$team["user_picture"] = UsersDataService::getUserProfilePicture($websoccer, $team["team_user_picture"], $team["team_user_email"], 20);
			$teams[] = $team;
		}
		$result->free();
		
		return $teams;
	}

}
?>
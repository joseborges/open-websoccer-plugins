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
require_once('MatchesDataService.class.php');

class LiveMatchesDataService extends MatchesDataService {

	public static function getLiveMatches(WebSoccer $websoccer, DbConnection $db) {
		//$fromTable = self::_getFromPart($websoccer);
	
		// where
		$whereCondition = "M.berechnet != '1' AND M.minutes > 0 AND M.datum < %d ORDER BY M.datum DESC";
		$parameters = array($websoccer->getNowAsTimestamp());
	
		return MatchesDataService::getMatchesByCondition($websoccer, $db, $whereCondition, $parameters, 20);
	/*
		// select
		$columns["M.id"] = "match_id";
		$columns["M.datum"] = "match_date";
		$columns["M.spieltyp"] = "match_type";
		$columns["HOME.id"] = "match_home_id";
		$columns["HOME.name"] = "match_home_name";
		$columns["GUEST.id"] = "match_guest_id";
		$columns["GUEST.name"] = "match_guest_name";
		$columns["M.home_tore"] = "match_home_tore";
		$columns["M.gast_tore"] = "match_gast_tore";
	
		$matchinfos = $db->queryCachedSelect($columns, $fromTable, $whereCondition, $parameters, 1);
		if (!count($matchinfos)) {
			$matchinfo = array();
		} else {
			while ($matchinfo = $result->fetch_array()) {
				$matches[] = $matchinfo;
				$matchinfo["match_type"] = self::_convertLeagueType($matchinfo["match_type"]);
			}
			$result->free();
		}
	
		return $matches;*/
	}
}
?>
<?php
/******************************************************

  HSE WebSoccer-Sim

  Copyright (c) 2013-2014 by

  Hofmann Software Engineering
  EMail: info@websoccer-sim.com
  Homepage: http://www.websoccer-sim.com

  THIS IS NOT FREEWARE! YOU NEED TO OBTAIN A
  VALID LICENCE IN ORDER TO BE ALLOWED TO USE
  THIS SOURCE CODE!
  
  DIES IST KEINE FREEWARE (KEINE KOSTENLOSE SOFTWARE).
  SIE MUESSEN EINE KORREKTE LIZENZ BESITZEN, UM DIESEN
  PROGRAMMCODE BENUTZEN ZU DUERFEN!

******************************************************/

/**
 * This event is triggered when a season is marked as completed for a club.
 * 
 */
class HalfSeasonOfTeamCompletedEvent extends AbstractEvent {
	
	/**
	 * @var int ID of team.
	 */
	public $teamId;
	
	/**
	 * @var int ID of season.
	 */
	public $seasonId;
	
	/**
	 * @var int Team's table position at the end of the season.
	 */
	public $rank;
	
	/**
	 * 
	 * @param WebSoccer $websoccer Application context.
	 * @param DbConnection $db DB connection.
	 * @param I18n $i18n Messages context.
	 * @param SimulationPlayer $player player data model.
	 * @param int $teamId ID of team.
	 * @param int $seasonId ID of season.
	 * @param int $rank Team's table position at the end of the season.
	 */
	function __construct(WebSoccer $websoccer, DbConnection $db, I18n $i18n, $teamId, $seasonId, $rank) {
		parent::__construct($websoccer, $db, $i18n);
		
		$this->teamId = $teamId;
		$this->seasonId = $seasonId;
		$this->rank = $rank;
	}

}

?>

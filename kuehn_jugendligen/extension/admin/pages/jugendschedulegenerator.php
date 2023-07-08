<?php
/******************************************************

  HSE WebSoccer-Sim

  Copyright (c) 2013 by

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

$r_titel = $i18n->getMessage("jugendschedulegenerator_navlabel");

echo "<h1>$r_titel</h1>";

if (!$admin["r_admin"] && !$admin["r_demo"] && !$admin[$page["permissionrole"]]) {
	throw new Exception($i18n->getMessage("error_access_denied"));
}

// generation might take more time than usual
ignore_user_abort(TRUE);
set_time_limit(0);

//********** Startseite **********
if (!$show) {

  ?>
  
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal">
    <input type="hidden" name="show" value="generate">
	<input type="hidden" name="site" value="<?php echo $site; ?>">
	
	<fieldset>
    <legend><?php echo $i18n->getMessage("jugendschedulegenerator_label"); ?></legend>
    
	<?php 
	$formFields = array();
	$seasonDefaultName = date("Y");
	
	$formFields["league"] = array("type" => "foreign_key", "labelcolumns" => "land,name", "jointable" => "jugendliga", "entity" => "league", "value" => "", "required" => "true");
	$formFields["seasonname"] = array("type" => "text", "value" => $seasonDefaultName, "required" => "true");
	
	$formFields["rounds"] = array("type" => "number", "value" => 2, "required" => "true");
	
	$formFields["firstmatchday"] = array("type" => "timestamp", "value" => "");
	$formFields["timebreak"] = array("type" => "number", "value" => 5);
	$formFields["timebreak_rounds"] = array("type" => "number", "value" => 0);
	
	foreach ($formFields as $fieldId => $fieldInfo) {
		echo FormBuilder::createFormGroup($i18n, $fieldId, $fieldInfo, $fieldInfo["value"], "schedulegenerator_label_");
	}	
	?>
	</fieldset>
	<div class="form-actions">
		<input type="submit" class="btn btn-primary" accesskey="s" title="Alt + s" value="<?php echo $i18n->getMessage("generator_button"); ?>"> 
		<input type="reset" class="btn" value="<?php echo $i18n->getMessage("button_reset"); ?>">
	</div>    
  </form>

  <?php

}

//********** validate, generate **********
elseif ($show == "generate") {

  if (!isset($_POST['league']) || $_POST['league'] <= 0) $err[] = $i18n->getMessage("generator_validationerror_noleague");
  if (!isset($_POST['rounds']) || $_POST['rounds'] <= 0 || $_POST['rounds'] > 10) $err[] = $i18n->getMessage("schedulegenerator_err_invalidrounds");
  if (!isset($_POST['timebreak']) || $_POST['timebreak'] <= 0 || $_POST['timebreak'] > 50) $err[] = $i18n->getMessage("schedulegenerator_err_invalidtimebreak");
  if ($admin['r_demo']) $err[] = $i18n->getMessage("validationerror_no_changes_as_demo");

  //##### Output error messages #####
  if (isset($err)) {

    include("validationerror.inc.php");

  }
  //##### Save #####
  else {

	// get teams
  	$result = $db->querySelect("id", $website->getConfig("db_prefix") . "_verein", "jugend_liga_id = %d", $_POST['league']);
	if (!$result->num_rows) {
		throw new Exception($i18n->getMessage("schedulegenerator_err__noteams"));
	}
	$teams = array();
	while ($team = $result->fetch_array()) {
		$teams[] = $team["id"];
	}
	$result->free();
	
	$schedule = ScheduleGenerator::createRoundRobinSchedule($teams);
	$numberOfMatchDaysPerRound = count($schedule);
	
	// add additional rounds (always swap home/guest)
	$rounds = (int) $_POST['rounds'];
	for ($round = 2; $round <= $rounds; $round++) {
		
		$startMatchday = count($schedule) + 1;
		$endMatchday = $startMatchday + $numberOfMatchDaysPerRound - 1;
		for ($matchday = $startMatchday; $matchday <= $endMatchday; $matchday++) {
			$originalMatchDay = $matchday - $numberOfMatchDaysPerRound;
			
			foreach ($schedule[$originalMatchDay] as $match) {
				$homeTeam = $match[1];
				$guestTeam = $match[0];
				$schedule[$matchday][] = array($homeTeam, $guestTeam);
			}
		}

	}
	
	// create season
	$seasoncolumns["name"] = $_POST["seasonname"];
	$seasoncolumns["liga_id"] = $_POST["league"];
	$db->queryInsert($seasoncolumns, $website->getConfig("db_prefix") . "_jugendsaison");
	$saisonId = $db->getLastInsertedId();
	
	// create matches
	$dateObj = DateTime::createFromFormat($website->getConfig("date_format") .", H:i",
			$_POST["firstmatchday_date"] .", ". $_POST["firstmatchday_time"]);
	$matchTimestamp = $dateObj->getTimestamp();
	$timeBreakSeconds = 3600 * 24 * $_POST['timebreak'];
	
	$matchTable = $website->getConfig("db_prefix") . "_youthmatch";
	
	foreach($schedule as $matchDay => $matches) {
		// creates matches of match day
		foreach ($matches as $match) {

			$homeTeam = $match[0];
			$guestTeam = $match[1];
			
			$teamcolumns = array();
      $teamcolumns["spieltyp"] = "Ligaspiel";
			$teamcolumns["liga_id"] = $_POST["league"];
			$teamcolumns["saison_id"] = $saisonId;
			$teamcolumns["spieltag"] = $matchDay;
			$teamcolumns["home_team_id"] = $homeTeam;
			$teamcolumns["guest_team_id"] = $guestTeam;
			$teamcolumns["matchdate"] = $matchTimestamp;
			
			$db->queryInsert($teamcolumns, $matchTable);
		}
		
		$matchTimestamp += $timeBreakSeconds;
		
		// add additional break between two rounds
		if (($matchDay % $numberOfMatchDaysPerRound) == 0) {
			$matchTimestamp += 3600 * 24 * $_POST['timebreak_rounds'];
		}
	}
	
	echo createSuccessMessage($i18n->getMessage("generator_success"), "");

      echo "<p>&raquo; <a href=\"?site=". $site ."\">". $i18n->getMessage("back_label") . "</a></p>\n";

  }

}

?>

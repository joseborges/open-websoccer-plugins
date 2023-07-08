<?php


    $eintrags_id = $website->getRequestParameter("id");
 
      $fromTableanpassung = $website->getConfig('db_prefix') .'_anpassungen';
      $whereConditionanpassung = "id = $eintrags_id";
		$resultanpassung = $db->querySelect("*", $fromTableanpassung, $whereConditionanpassung);
		$anpassung = $resultanpassung->fetch_array();
       
      $spieler_id = $anpassung['spieler_id']; 
      $userid = $anpassung['user_id'];
      

// remove pending state
$db->queryUpdate(array("admin_approval_pending" => "0"), $website->getConfig("db_prefix") . "_anpassungen",
		"id = %d", $website->getRequestParameter("id"));
    
     


// Nachricht an User das Anpassung abgelehnt wurde

$player = PlayersDataService::getPlayerById($website, $db, $spieler_id);
$playerName = (strlen($player["player_pseudonym"])) ? $player["player_pseudonym"] : $player["player_firstname"] . " " . $player["player_lastname"];


NotificationsDataService::createNotification($website, $db, $userid, 
						"spieler_nicht_angepasst", array("spieler" => $playerName), "anpassung", "player",  'id=' . $anpassung['spieler_id']);
  
// create success message
echo createSuccessMessage($i18n->getMessage("mwa_approval_abgelehnt"), "");
?>   
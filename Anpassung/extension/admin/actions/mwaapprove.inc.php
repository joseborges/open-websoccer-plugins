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
 // erst Spieler_ID usw. aus der Tabelle "Anpassungen" mit hilfe der mitgegebenen ID auslesen
 // dann neuen Marktwert bei Spieler eintragen.
 // dann admin_approval_pending auf null setzen wenn wir die anpassungen speichern wollen ansonsten den Eintrag löschen

 // erst Spieler_ID usw. aus der Tabelle "Anpassungen" mit hilfe der mitgegebenen ID auslesen
    $eintrags_id = $website->getRequestParameter("id");
 
      $fromTableanpassung = $website->getConfig('db_prefix') .'_anpassungen';
      $whereConditionanpassung = "id = $eintrags_id";
		$resultanpassung = $db->querySelect("*", $fromTableanpassung, $whereConditionanpassung);
		$anpassung = $resultanpassung->fetch_array();
       
      $spieler_id = $anpassung['spieler_id']; 
      $marktwert_neu = $anpassung['marktwert_neu'];
      $position_main = $anpassung['position_main'];
      $position_second = $anpassung['position_second'];
      $userid = $anpassung['user_id'];
      
  // Wenn neuer Marktwert dann das Gehalt, die Stärke und die Technik anpassen   
      if ($marktwert_neu != NULL) {
      
       if ($marktwert_neu >= 0 AND $marktwert_neu <= 590000) {
            $staerke = 50;
            $technik = 50;
          }
          
        elseif($marktwert_neu >= 600000 AND $marktwert_neu <= 1290000) {
            $staerke = 51;
            $technik = 51;
          }
          
        elseif($marktwert_neu >= 1300000 AND $marktwert_neu <= 1990000) {
            $staerke = 52;
            $technik = 52;
          }
          
        elseif($marktwert_neu >= 2000000 AND $marktwert_neu <= 2590000) {
            $staerke = 53;
            $technik = 53;
          }
          
        elseif($marktwert_neu >= 2600000 AND $marktwert_neu <= 3290000) {
            $staerke = 54;
            $technik = 54;
          }
          
        elseif($marktwert_neu >= 3300000 AND $marktwert_neu <= 4090000) {
            $staerke = 55;
            $technik = 55;
          }
          
        elseif($marktwert_neu >= 4100000 AND $marktwert_neu <= 4790000) {
            $staerke = 56;
            $technik = 56;
          }
          
         elseif($marktwert_neu >= 4800000 AND $marktwert_neu <= 5490000) {
            $staerke = 57;
            $technik = 57;
          }
          
         elseif($marktwert_neu >= 5500000 AND $marktwert_neu <= 6190000) {
            $staerke = 58;
            $technik = 58;
          }
          
          elseif($marktwert_neu >= 6200000 AND $marktwert_neu <= 6990000) {
            $staerke = 59;
            $technik = 59;
          }
          
          elseif($marktwert_neu >= 7000000 AND $marktwert_neu <= 7590000) {
            $staerke = 60;
            $technik = 60;
          }
          
          elseif($marktwert_neu >= 7600000 AND $marktwert_neu <= 8290000) {
            $staerke = 61;
            $technik = 61;
          }
          
          elseif($marktwert_neu >= 8300000 AND $marktwert_neu <= 8990000) {
            $staerke = 62;
            $technik = 62;
          }
          
          elseif($marktwert_neu >= 9000000 AND $marktwert_neu <= 9690000) {
            $staerke = 63;
            $technik = 63;
          }
          
          elseif($marktwert_neu >= 9700000 AND $marktwert_neu <= 10490000) {
            $staerke = 64;
            $technik = 64;
          }
          
          elseif($marktwert_neu >= 10500000 AND $marktwert_neu <= 12490000) {
            $staerke = 65;
            $technik = 65;
          }
          
          elseif($marktwert_neu >= 12500000 AND $marktwert_neu <= 15490000) {
            $staerke = 66;
            $technik = 66;
          }
          
           elseif($marktwert_neu >= 15500000 AND $marktwert_neu <= 18490000) {
            $staerke = 67;
            $technik = 67;
          }
          
          elseif($marktwert_neu >= 18500000 AND $marktwert_neu <= 21490000) {
            $staerke = 68;
            $technik = 68;
          }
          
          elseif($marktwert_neu >= 21500000 AND $marktwert_neu <= 24490000) {
            $staerke = 69;
            $technik = 69;
          }
          
          elseif($marktwert_neu >= 24500000 AND $marktwert_neu <= 27490000) {
            $staerke = 70;
            $technik = 70;
          }
          
          elseif($marktwert_neu >= 27500000 AND $marktwert_neu <= 30490000) {
            $staerke = 71;
            $technik = 71;
          }
          
          elseif($marktwert_neu >= 30500000 AND $marktwert_neu <= 33490000) {
            $staerke = 72;
            $technik = 72;
          }
          
          elseif($marktwert_neu >= 33500000 AND $marktwert_neu <= 36490000) {
            $staerke = 73;
            $technik = 73;
          }
          
          elseif($marktwert_neu >= 36500000 AND $marktwert_neu <= 39490000) {
            $staerke = 74;
            $technik = 74;
          }
          
          elseif($marktwert_neu >= 39500000 AND $marktwert_neu <= 42490000) {
            $staerke = 75;
            $technik = 75;
          }
          
          elseif($marktwert_neu >= 42500000 AND $marktwert_neu <= 45990000) {
            $staerke = 76;
            $technik = 76;
          }
          
          elseif($marktwert_neu >= 46510000 AND $marktwert_neu <= 51990000) {
            $staerke = 77;
            $technik = 77;
          }
          
          elseif($marktwert_neu >= 52570000 AND $marktwert_neu <= 57990000) {
            $staerke = 78;
            $technik = 78;
          }
          
          elseif($marktwert_neu >= 58630000 AND $marktwert_neu <= 63990000) {
            $staerke = 79;
            $technik = 79;
          }
          
          elseif($marktwert_neu >= 64000000 AND $marktwert_neu <= 69990000) {
            $staerke = 80;
            $technik = 80;
          }
          
          elseif($marktwert_neu >= 70000000 AND $marktwert_neu <= 75990000) {
            $staerke = 81;
            $technik = 81;
          }
          
          elseif($marktwert_neu >= 76000000 AND $marktwert_neu <= 82990000) {
            $staerke = 82;
            $technik = 82;
          }
          
          elseif($marktwert_neu >= 83000000 AND $marktwert_neu <= 89990000) {
            $staerke = 83;
            $technik = 83;
          }
          
          elseif($marktwert_neu >= 90000000 AND $marktwert_neu <= 97990000) {
            $staerke = 84;
            $technik = 84;
          }
          
          elseif($marktwert_neu >= 98000000 AND $marktwert_neu <= 104990000) {
            $staerke = 85;
            $technik = 85;
          }
          
          elseif($marktwert_neu >= 105000000 AND $marktwert_neu <= 111990000) {
            $staerke = 86;
            $technik = 86;
          }
          
          elseif($marktwert_neu >= 112000000 AND $marktwert_neu <= 117990000) {
            $staerke = 87;
            $technik = 87;
          }
          
          elseif($marktwert_neu >= 118000000 AND $marktwert_neu <= 124990000) {
            $staerke = 88;
            $technik = 88;
          }
          
          elseif($marktwert_neu >= 125000000 AND $marktwert_neu <= 129990000) {
            $staerke = 89;
            $technik = 89;
          }
          
          elseif($marktwert_neu >= 130000000 AND $marktwert_neu <= 140000000) {
            $staerke = 90;
            $technik = 90;
          }
          
          elseif($marktwert_neu > 140000000) {
            $staerke = 91;
            $technik = 91;
          }   
                 
                    
      $db->queryUpdate(array( 
          "marktwert" => $marktwert_neu, 
          "w_staerke" => $staerke, 
          "w_technik" => $technik, 
          "vertrag_gehalt" => $marktwert_neu/1000
        ), $website->getConfig('db_prefix') . "_spieler", "id = '$spieler_id'" );
      }
      
      
      if ($position_main != NULL) {               
      
      
          if ($position_main == "T") {               
            $db->queryUpdate(array( 
          "position" => Torwart,
          "position_main" => $position_main
        ), $website->getConfig('db_prefix') . "_spieler", "id = '$spieler_id'" );
      }
      
      elseif ($position_main == "LV") {               
      $db->queryUpdate(array( 
          "position" => Abwehr,
          "position_main" => $position_main
        ), $website->getConfig('db_prefix') . "_spieler", "id = '$spieler_id'" );
      }
      
      elseif ($position_main == "IV") {               
      $db->queryUpdate(array( 
          "position" => Abwehr,
          "position_main" => $position_main
        ), $website->getConfig('db_prefix') . "_spieler", "id = '$spieler_id'" );
      }
      
      elseif ($position_main == "RV") {               
      $db->queryUpdate(array( 
          "position" => Abwehr,
          "position_main" => $position_main
        ), $website->getConfig('db_prefix') . "_spieler", "id = '$spieler_id'" );
      }
      
      
      elseif ($position_main == "RM") {               
      $db->queryUpdate(array( 
          "position" => Mittelfeld,
          "position_main" => $position_main
        ), $website->getConfig('db_prefix') . "_spieler", "id = '$spieler_id'" );
      }
      
      elseif ($position_main == "LM") {               
      $db->queryUpdate(array( 
          "position" => Mittelfeld,
          "position_main" => $position_main
        ), $website->getConfig('db_prefix') . "_spieler", "id = '$spieler_id'" );
      }
      
      elseif ($position_main == "ZM") {               
      $db->queryUpdate(array( 
          "position" => Mittelfeld,
          "position_main" => $position_main
        ), $website->getConfig('db_prefix') . "_spieler", "id = '$spieler_id'" );
      }
      
      elseif ($position_main == "OM") {               
      $db->queryUpdate(array( 
          "position" => Mittelfeld,
          "position_main" => $position_main
        ), $website->getConfig('db_prefix') . "_spieler", "id = '$spieler_id'" );
      }
      
      elseif ($position_main == "DM") {               
      $db->queryUpdate(array( 
          "position" => Mittelfeld,
          "position_main" => $position_main
        ), $website->getConfig('db_prefix') . "_spieler", "id = '$spieler_id'" );
      }
      
      
      
      elseif ($position_main == "LS") {               
      $db->queryUpdate(array( 
          "position" => Sturm,
          "position_main" => $position_main
        ), $website->getConfig('db_prefix') . "_spieler", "id = '$spieler_id'" );
      }
      
      elseif ($position_main == "RS") {               
      $db->queryUpdate(array( 
          "position" => Sturm,
          "position_main" => $position_main
        ), $website->getConfig('db_prefix') . "_spieler", "id = '$spieler_id'" );
      }
      
      elseif ($position_main == "MS") {               
      $db->queryUpdate(array( 
          "position" => Sturm,
          "position_main" => $position_main
        ), $website->getConfig('db_prefix') . "_spieler", "id = '$spieler_id'" );
      }
      
      
       }
       
       
      
      if ($position_second != NULL) {               
      $db->queryUpdate(array( 
          "position_second" => $position_second
        ), $website->getConfig('db_prefix') . "_spieler", "id = '$spieler_id'" );
      }
      
      

// remove pending state
$db->queryUpdate(array("admin_approval_pending" => "0"), $website->getConfig("db_prefix") . "_anpassungen",
		"id = %d", $website->getRequestParameter("id"));
    
     


// Nachricht an User das Anpassung vorgenommen wurde

$player = PlayersDataService::getPlayerById($website, $db, $spieler_id);
$playerName = (strlen($player["player_pseudonym"])) ? $player["player_pseudonym"] : $player["player_firstname"] . " " . $player["player_lastname"];


NotificationsDataService::createNotification($website, $db, $userid, 
						"spieler_angepasst", array("spieler" => $playerName), "anpassung", "player",  'id=' . $anpassung['spieler_id']);
  
// create success message
echo createSuccessMessage($i18n->getMessage("mwa_approval_success"), "");

?>   
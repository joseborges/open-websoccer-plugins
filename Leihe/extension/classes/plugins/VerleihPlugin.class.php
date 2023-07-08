<?php

class VerleihPlugin {

	public static function onPlayerTrained(PlayerTrainedEvent $event) {

	}
	
	public static function onTicketsComputed(TicketsComputedEvent $event) {

	}
	
	public static function onYouthPlayerScouted(YouthPlayerScoutedEvent $event) {

	}
	
	public static function onYouthPlayerPlayed(YouthPlayerPlayedEvent $event) {

	}
	
	public static function onUserRegistered(UserRegisteredEvent $event) {

	}

	public static function onSeasonCompleted(SeasonOfTeamCompletedEvent $event) {
    
    
		$fromTable = $event->websoccer->getConfig('db_prefix') . '_spieler';

		$result = $event->db->querySelect("id, verein_id, lending_owner_id", $fromTable, "verein_id = '%s' and lending_owner_id >= 1 and lending_dauer = 2", $event->teamId);
		
	while($verleiher = $result->fetch_array()){
    $besitzer =  $verleiher['lending_owner_id'];
    $spieler_id =  $verleiher['id'];
    
      $columns = array();
			$columns['verein_id'] = $besitzer;
      $columns['lending_owner_id'] = 0;
      $columns['lending_dauer'] = 0;
      $columns['lending_fee'] = 0;
      $columns['lending_matches'] = 0;
			
			$event->db->queryUpdate($columns, $event->websoccer->getConfig('db_prefix') . '_spieler', "id = $spieler_id");
        
  echo "Hier meldet sich das Verleihplugin! Spieler = " . $verleiher['id'] ." wurde von = " . $verleiher['verein_id'] ." zu= " . $verleiher['lending_owner_id'] ." verschoben, da die Leihe beendet wurde.<br>";      
                                            }
                                                                            }
		public static function onHalfSeasonCompleted(HalfSeasonOfTeamCompletedEvent $event) {
    
    
		$fromTable = $event->websoccer->getConfig('db_prefix') . '_spieler';

		$result = $event->db->querySelect("id, verein_id, lending_owner_id", $fromTable, "verein_id = '%s' and lending_owner_id >= 1 and lending_dauer = 1", $event->teamId);
		
	while($verleiher = $result->fetch_array()){
    $besitzer =  $verleiher['lending_owner_id'];
    $spieler_id =  $verleiher['id'];
    
      $columns = array();
			$columns['verein_id'] = $besitzer;
      $columns['lending_owner_id'] = 0;
      $columns['lending_dauer'] = 0;
      $columns['lending_fee'] = 0;
      $columns['lending_matches'] = 0;
			
			$event->db->queryUpdate($columns, $event->websoccer->getConfig('db_prefix') . '_spieler', "id = $spieler_id");
        
  echo "Hier meldet sich das Verleihplugin! Spieler =" . $verleiher['id'] ." wurde von = " . $verleiher['verein_id'] ." zu= " . $verleiher['lending_owner_id'] ." verschoben, da die Leihe beendet wurde.<br>";      
                                            }
                                                                            } 
}
?>			
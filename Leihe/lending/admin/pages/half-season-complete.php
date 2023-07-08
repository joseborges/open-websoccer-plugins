<?php
/******************************************************

  This file is part of OpenWebSoccer-Sim.

  OpenWebSoccer-Sim is free software: you can redistribute it 
  and/or modify it under the terms of the 
  GNU Lesser General Public License 
  as published by the Free Software Foundation, either version 3 of
  the License, or any later version.

  OpenWebSoccer-Sim is distributed in the hope that it will be
  useful, but WITHOUT ANY WARRANTY; without even the implied
  warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
  See the GNU Lesser General Public License for more details.

  You should have received a copy of the GNU Lesser General Public 
  License along with OpenWebSoccer-Sim.  
  If not, see <http://www.gnu.org/licenses/>.

******************************************************/

$mainTitle = $i18n->getMessage('half_season_complete_title');

if (isset($_REQUEST['id'])) $id = (int) $_REQUEST['id'];

echo '<h1>' . $mainTitle .'</h1>';

if (!$admin['r_admin'] && !$admin['r_demo'] && !$admin[$page['permissionrole']]) {
	throw new Exception($i18n->getMessage('error_access_denied'));
}

//********** Pick season **********
if (!$show) {

  ?>
  <p><?php echo $i18n->getMessage('half-complete-season_introduction'); ?></p>

  <?php 
  $columns = array();
  $columns['S.id'] = 'id';
  $columns['S.name'] = 'name';
  $columns['L.name'] = 'league_name';

  $fromTable = $conf['db_prefix'] .'_saison AS S';
  $fromTable .= ' INNER JOIN ' . $conf['db_prefix'] .'_liga AS L ON L.id = S.liga_id';
   
  $whereCondition = 'S.halbsaison_beendet = \'0\' AND (SELECT COUNT(*) FROM '. $conf['db_prefix'] . '_spiel AS M WHERE M.berechnet = \'1\' AND M.saison_id = S.id) = (SELECT COUNT(*) FROM '. $conf['db_prefix'] . '_spiel AS M WHERE M.berechnet = \'0\' AND M.saison_id = S.id) ORDER BY L.name ASC, S.name ASC';
  $result = $db->querySelect($columns, $fromTable, $whereCondition);
  if (!$result->num_rows) {
	echo '<p><strong> Keine Hinrunden zum beenden gefunden.</strong></p>';
  } else {
?>
  
  <table class='table table-striped'>
  	<thead>
  		<tr>
  			<th><?php echo $i18n->getMessage('entity_season_name'); ?></th>
  			<th><?php echo $i18n->getMessage('entity_season_liga_id'); ?></th>
  		</tr>
  	</thead>
  	<tbody>
  	<?php 
		
		while ($season = $result->fetch_array()) {
			echo '<tr>';
			echo '<td><a href=\'?site='. $site . '&show=select&id='. $season['id'] . '\'>'. $season['name'] . '</a></td>';
			echo '<td>'. $season['league_name'] . '</td>';
			echo '</tr>';
		}
		
	?>
  	</tbody>
  </table>
  
  <?php
  }

  $result->free();
}

	//********** selected season **********
elseif ($show == 'select') {
	$columns = '*';
	$whereCondition = 'id = %d';
	$result = $db->querySelect($columns, $conf['db_prefix'] .'_saison', $whereCondition, $id, 1);
	$season = $result->fetch_array();
	if (!$season) {
		throw new Exception('Invalid URL - Item does not exist.');
	}
	$result->free();

	?>
	<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' class='form-horizontal'>
	<input type='hidden' name='show' value='complete'>
	<input type='hidden' name='id' value='<?php echo $id; ?>'>
	<input type='hidden' name='site' value='<?php echo $site; ?>'>
	
	<fieldset>
	<legend><?php echo escapeOutput($season['name']); ?></legend>
    
	<?php 

	?>
	</fieldset>
	<div class='form-actions'>
		<input type='submit' class='btn btn-primary' accesskey='s' title='Alt + s' value='<?php echo $i18n->getMessage('season_complete_submit'); ?>'> 
		<input type='reset' class='btn' value='<?php echo $i18n->getMessage('button_reset'); ?>'>
	</div>    
  </form>
	<?php 
	
	//********** end season **********
} elseif ($show == 'complete') {
	if ($admin['r_demo']) $err[] = $i18n->getMessage('validationerror_no_changes_as_demo');
	
	if (isset($err)) {
	
		include('validationerror.inc.php');
	
	} else {
  		$seasoncolumns = array();
		$seasoncolumns['halbsaison_beendet'] = '1';
	
		$columns = '*';
		$whereCondition = 'id = %d AND halbsaison_beendet = \'0\'';
		$result = $db->querySelect($columns, $conf['db_prefix'] .'_saison', $whereCondition, $id, 1);
		$season = $result->fetch_array();
		if (!$season) {
			throw new Exception('Invalid request - Item does not exist.');
		}
		$result->free();
		
		$seasoncolumns = array();
		$seasoncolumns['halbsaison_beendet'] = '1';
		
  		// get teams in their ranking order
		$columns = 'id, sponsor_id, min_target_rank, user_id';
		$fromTable = $conf['db_prefix'] .'_verein';
		$whereCondition = 'liga_id = %d AND sa_spiele > 0 ORDER BY sa_punkte DESC, (sa_tore - sa_gegentore) DESC, sa_siege DESC, sa_unentschieden DESC, sa_tore DESC';
		$result = $db->querySelect($columns, $fromTable, $whereCondition, $season['liga_id']);
		
		
		$rank = 1;
		
		
		
	
		while($team = $result->fetch_array()) {


			// dispatch event
			$event = new HalfSeasonOfTeamCompletedEvent($website, $db, $i18n,
					 $team['id'], $season['id'], $rank);
			PluginMediator::dispatchEvent($event);
			
			$rank++;
		}
		$result->free();
		
			// update season
		$db->queryUpdate($seasoncolumns, $conf['db_prefix'] .'_saison', 'id = %d', $season['id']);
		echo createSuccessMessage($i18n->getMessage('alert_save_success'), '');
		
		echo '<p>&raquo; <a href=\'?site='. $site .'\'>'. $i18n->getMessage('back_label') . '</a></p>';
	
	}
}

?>

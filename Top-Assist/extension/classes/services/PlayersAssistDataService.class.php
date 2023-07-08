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

/**
 *
 */
class PlayersAssistDataService {


    public static function getTopAssist(WebSoccer $websoccer, DbConnection $db, $limit = 20, $leagueId = null) {
        $parameters = array();
    
        $columns['P.id'] = 'id';
        $columns['P.vorname'] = 'firstname';
        $columns['P.nachname'] = 'lastname';
        $columns['P.kunstname'] = 'pseudonym';
    
        $columns['P.sa_tore'] = 'goals';
        $columns['P.sa_assists'] = 'assists';
        $columns['P.sa_spiele'] = 'matches';
            
        $columns['P.transfermarkt'] = 'transfermarket';
    
        $columns['C.id'] = 'team_id';
        $columns['C.name'] = 'team_name';
    
        $fromTable = $websoccer->getConfig('db_prefix') . '_spieler AS P';
        $fromTable .= ' LEFT JOIN ' . $websoccer->getConfig('db_prefix') . '_verein AS C ON C.id = P.verein_id';
    
        $whereCondition = 'P.status = \'1\' AND P.sa_assists > 0';
        if ($leagueId != null) {
            $whereCondition .= ' AND liga_id = %d';
            $parameters[] = (int) $leagueId;
        }
        $whereCondition .= ' ORDER BY P.sa_assists DESC, P.sa_tore DESC, P.sa_spiele ASC, P.id ASC';
    
        $result = $db->querySelect($columns, $fromTable, $whereCondition, $parameters, $limit);
    
        $players = array();
        while ($player = $result->fetch_array()) {
            $players[] = $player;
        }
        $result->free();
    
        return $players;
    }
	
}
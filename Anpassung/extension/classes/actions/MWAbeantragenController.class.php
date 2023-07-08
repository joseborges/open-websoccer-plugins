<?php

class MWAbeantragenController implements IActionController {
	private $_i18n;
	private $_websoccer;
	private $_db;
	
	private $_addedPlayers;
	private $_isNationalTeam;
	
	public function __construct(I18n $i18n, WebSoccer $websoccer, DbConnection $db) {
		$this->_i18n = $i18n;
		$this->_websoccer = $websoccer;
		$this->_db = $db;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see IActionController::executeAction()
	 */
	public function executeAction($parameters) {
  
    $user = $this->_websoccer->getUser();
    $userid = $user->id;
    $spielerschonantrag = $parameters['player_id'];
	  $columns['spieler_id'] = $parameters['player_id'];
		$columns['marktwert_neu'] = $parameters['marktwert_neu'];
    $columns['position_main'] = $parameters['posi1'];
    $columns['position_second'] = $parameters['posi2'];
    $columns['link'] = $parameters['link'];	 
    $columns['user_id'] = $userid; 
     
     
     $fromTable = $this->_websoccer->getConfig("db_prefix") . "_anpassungen";  
      $whereCondition = "spieler_id = $spielerschonantrag and admin_approval_pending = 1";
			$result = $this->_db->querySelect("id as id", $fromTable, $whereCondition);
      $spieler = $result->fetch_array();
		
     if (isset($spieler)) {
     $this->_websoccer->addFrontMessage(new FrontMessage(MESSAGE_TYPE_WARNING,
				$this->_i18n->getMessage("mwa_antrag_warning"),
				""));
  	   
       }else {
		

			$this->_db->queryInsert($columns, $fromTable);
      
    // create success message
		$this->_websoccer->addFrontMessage(new FrontMessage(MESSAGE_TYPE_SUCCESS,
				$this->_i18n->getMessage("mwa_antrag_success"),
				""));  
     }         			
		return "myteam";
 
		}
}

?>
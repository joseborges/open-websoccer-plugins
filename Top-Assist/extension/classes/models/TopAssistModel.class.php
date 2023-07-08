<?php

define('NUMBER_OF_PLAYERS', 20);

/**
 * Provides list of players with highest assists.
 */
class TopAssistModel implements IModel {
    private $_db;
    private $_i18n;
    private $_websoccer;
    
    public function __construct($db, $i18n, $websoccer) {
        $this->_db = $db;
        $this->_i18n = $i18n;
        $this->_websoccer = $websoccer;
    }
    
    /**
     * (non-PHPdoc)
     * @see IModel::renderView()
     */
    public function renderView() {
        return TRUE;
    }
    
    /**
     * (non-PHPdoc)
     * @see IModel::getTemplateParameters()
     */
    public function getTemplateParameters() {
        return array('players' => PlayersAssistDataService::getTopAssist($this->_websoccer, $this->_db, NUMBER_OF_PLAYERS, 
                        $this->_websoccer->getRequestParameter('leagueid')),
                    'leagues' => LeagueDataService::getLeaguesSortedByCountry($this->_websoccer, $this->_db));
    }
    
}
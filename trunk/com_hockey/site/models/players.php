<?php

/*
 * @package Joomla 1.6
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Hockey League
 * @copyright Copyright (C) Klich Jarosław
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class HockeyModelPlayers extends JModel {

    private $_team = null;

    public function __construct() {
        parent::__construct();
        }

    public function setTeam($id) {
        $id = (int) $id;
        $this->_team = $id;
    }
    
    public function getNameTeam() {
        $query = "SELECT name FROM #__hockey_teams WHERE id=".$this->_db->Quote($this->_team);
        $this->_db->setQuery($query);
        return $this->_db->loadResult();
    }

    public function getListPlayers() {
        $query = "SELECT P.id,P.nazwisko,P.imie,P.pozycja,P.data_u,P.foto,P.wzrost,P.waga,P.klubold,P.nr "
                . "FROM #__hockey_players  P "
                . "WHERE ( P.published=1 AND P.klub=". $this->_db->Quote($this->_team) .") "
                . "ORDER BY  P.pozycja ,P.nazwisko, P.imie";
        return $this->_getList($query, 0, 0);
    }
}
?>
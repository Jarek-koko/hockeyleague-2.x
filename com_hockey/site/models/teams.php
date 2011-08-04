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

class HockeyModelTeams extends JModel {

    private $_list = null;
    private $_idsezon = null;

    public function __construct() {
        parent::__construct();
        $session = &JFactory::getSession();
        $this->_idsezon = (int) $session->get('idsezon', 0);
    }

    public function getData() {
        if (!$this->_list) {
            $this->_list = $this->_getList($this->_setQuery(), 0, 0);
        }
        return $this->_list;
    }

    protected function _setQuery() {
        $query = "SELECT  N.name AS nazwa_d, N.logo, N.description "
                . "FROM #__hockey_tabela T "
                . "INNER JOIN #__hockey_teams N ON (T.team_id = N.id) "
                . "WHERE T.id_system=" . $this->_db->Quote($this->_idsezon) . " AND T.published=1 "
                . "ORDER BY name ASC";
        return $query;
    }

    public function setSezon($idsezon, $show) {
        $idsezon = (int) $idsezon;
        $show = (int) $show;

        if (($this->_idsezon == 0) || ($show == 0)) {
            $this->_idsezon = $idsezon;
        }
    }

    public function getSezon() {
        return $this->_idsezon;
    }

    public function getSezonList() {
        $query = 'SELECT id AS value, nazwa AS text FROM #__hockey_system ORDER BY id DESC;';
        $this->_db->setQuery($query);
        return $this->_db->loadObjectList();
    }
}

?>
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

class HockeyModelSchedule extends JModel {

    private $_list = null;
    private $_idsezon = null;
    private $_tom = null;
    private $_where = null;

    public function __construct() {
        parent::__construct();
        $session = &JFactory::getSession();
        $this->_idsezon = (int) $session->get('idsezon', 0);
        $this->_tom = (int) $session->get('tom', 0);
        $this->_where = (int) $session->get('where', 0);
    }

    public function setSezon($idsezon) {
        $idsezon = (int) $idsezon;
        if ($this->_idsezon == 0) {
            $this->_idsezon = $idsezon;
        }
    }

    public function getSezon() {
        return $this->_idsezon;
    }

    public function getTom() {
        return $this->_tom;
    }

    public function getWhere() {
        return $this->_where;
    }

    public function getData() {
        $query = 'SELECT id AS value, nazwa AS text FROM #__hockey_system ORDER BY id DESC';
        $this->_db->setQuery($query);
        return $this->_db->loadObjectList();
    }

    public function getAList($idteams) {

        if (!$this->_list) {
            $myteam = ($idteams != 0 ) ? $idteams : false;
            $where = '';
            if ($myteam) {
                switch ($this->_where) {
                    case 2:
                        $where = ' AND (M.druzyna2= ' . $myteam . ' ) ';
                        break;
                    case 1:
                        $where = ' AND (M.druzyna1=' . $myteam . ' ) ';
                        break;
                    default:
                        $where = ' AND (M.druzyna1=' . $myteam . ' OR M.druzyna2=' . $myteam . ' ) ';
                        break;
                }
            }

            switch ($this->_tom) {
                case 2:
                    $tom = ' AND (M.type_of_match=2) ';
                    break;
                case 1:
                    $tom = ' AND (M.type_of_match=1) ';
                    break;
                default:
                    $tom = ' AND (M.type_of_match=0) ';
                    break;
            }
            $query = "SELECT M.id,M.data,T1.name AS team1,T2.name AS team2, M.druzyna1,M.druzyna2, M.wynik_1,M.wynik_2,M.m_dogr,M.m_karne ,M.id_kolejka ,M.type_of_match ,MONTH(M.data) as mm ,M.w1p1,M.w2p1,M.w1p2,M.w2p2,M.w1p3,M.w2p3,M.w1ot,M.w2ot,M.w1so,M.w2so,M.time "
                    . "FROM #__hockey_match M  "
                    . "LEFT JOIN #__hockey_teams T1 ON (M.druzyna1=T1.id) "
                    . "LEFT JOIN #__hockey_teams T2 ON (M.druzyna2=T2.id) "
                    . "WHERE M.published='1' " . $where . " " . $tom . " AND M.id_system=" . $this->_db->Quote($this->_idsezon)
                    . " ORDER BY M.type_of_match,M.data,M.id_kolejka";
            $this->_list = $this->_getList($query, 0, 0);
        }
        return $this->_list;
    }

}

?>
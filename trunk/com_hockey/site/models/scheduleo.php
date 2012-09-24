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

class HockeyModelScheduleo extends JModel {

    private $_list = null;
    private $_idsezon = null;
    private $_event = null;

    public function __construct() {
        parent::__construct();
        $session = &JFactory::getSession();
    }

    public function setSezon($idsezon) {
        $this->_idsezon = (int) $idsezon;
    }

    public function setEvent($event) {
        $this->_event = (int) $event;
        $a = range(0,9);
        if (!in_array($this->_event, $a, true)) {
            $this->_event = 0;
        }
    }
    
    public function getList() {
        if ($this->_event == 0) {
            $query = "SELECT M.id,M.druzyna1,M.druzyna2,M.data,T1.name AS team1,T2.name AS team2,M.wynik_1,M.wynik_2,M.m_dogr,M.m_karne ,M.id_kolejka,M.w1p1,M.w2p1,M.w1p2,M.w2p2,M.w1p3,M.w2p3,M.w1ot,M.w2ot,M.w1so,M.w2so,M.time "
                    . "FROM #__hockey_match M  "
                    . "LEFT JOIN #__hockey_teams T1 ON (M.druzyna1=T1.id) "
                    . "LEFT JOIN #__hockey_teams T2 ON (M.druzyna2=T2.id) "
                    . "WHERE M.published='1' AND M.type_of_match='2' AND M.id_system=" . $this->_db->Quote($this->_idsezon)
                    . " ORDER BY M.id_kolejka ,M.data";
            $this->_list = $this->_getList($query, 0, 0);
        } else {
            $query = "SELECT M.id,M.druzyna1,M.druzyna2,M.data,T1.name AS team1,T2.name AS team2,M.wynik_1,M.wynik_2,M.m_dogr,M.m_karne ,M.id_kolejka,M.w1p1,M.w2p1,M.w1p2,M.w2p2,M.w1p3,M.w2p3,M.w1ot,M.w2ot,M.w1so,M.w2so,M.time "
                    . "FROM #__hockey_match M  "
                    . "LEFT JOIN #__hockey_teams T1 ON (M.druzyna1=T1.id) "
                    . "LEFT JOIN #__hockey_teams T2 ON (M.druzyna2=T2.id) "
                    . "WHERE M.published='1' AND M.type_of_match='2' AND M.id_system=" . $this->_db->Quote($this->_idsezon) . " and M.id_kolejka=" . $this->_db->Quote($this->_event)
                    . " ORDER BY M.id_kolejka ,M.data";
            $this->_list = $this->_getList($query, 0, 0);
        }
        return $this->_list;
    }
}
?>
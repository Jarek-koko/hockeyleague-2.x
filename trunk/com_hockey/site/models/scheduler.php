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

class HockeyModelScheduler extends JModel {

    private $_list = null;
    private $_idsezon = null;
    private $_matchday = null;


    public function __construct() {
        parent::__construct ();
        $session = &JFactory::getSession();
        $this->_idsezon = (int) $session->get('idsezon' , 0);
        $this->_matchday = (int) $session->get('matchday' , 1);
    }

    public function setSezon($idsezon, $show) {
        $idsezon = (int) $idsezon;
        $show = (int) $show;
        
        if (($this->_idsezon == 0) || ($show == 0)) {
            $this->_idsezon = $idsezon;
        } 
    }
    
    public function getSezon(){
        return $this->_idsezon;
    }

    public function getMatchday() {
        return $this->_matchday;
    }

    public function getData() {
        $query = 'SELECT id AS value, nazwa AS text FROM #__hockey_system ORDER BY id DESC';
        $this->_db->setQuery($query);
        return $this->_db->loadObjectList();
    }

    public function getListMatchday() {
        $query = "SELECT DISTINCT id_kolejka FROM #__hockey_match WHERE id_system =" . $this->_db->Quote($this->_idsezon) 
               . " AND type_of_match='0' AND published='1' ORDER BY id_kolejka";
        $this->_db->setQuery($query);
        return $this->_db->loadResultArray();
    }

    public function getListMatches() {
        if (!$this->_list) {
            $query = "SELECT M.id,M.data,T1.name AS team1,T2.name AS team2,M.druzyna1, M.druzyna2, M.wynik_1,M.wynik_2,M.m_dogr,M.m_karne,M.w1p1,M.w2p1,M.w1p2,M.w2p2,M.w1p3,M.w2p3,M.w1ot,M.w2ot,M.w1so,M.w2so "
                    . "FROM #__hockey_match M  "
                    . "LEFT JOIN #__hockey_teams T1 ON (M.druzyna1=T1.id) "
                    . "LEFT JOIN #__hockey_teams T2 ON (M.druzyna2=T2.id) "
                    . "WHERE M.published='1' AND M.type_of_match='0'"
                    . " AND M.id_system=" . $this->_db->Quote($this->_idsezon) . " AND M.id_kolejka=" . $this->_db->Quote($this->_matchday)
                    . " ORDER BY M.data";
            $this->_list = $this->_getList($query, 0, 0);
            
            if (empty($this->_list)) {
                $query = "SELECT M.id,M.data,T1.name AS druzyna1,T2.name AS druzyna2,M.wynik_1,M.wynik_2,M.m_dogr,M.m_karne,M.w1p1,M.w2p1,M.w1p2,M.w2p2,M.w1p3,M.w2p3,M.w1ot,M.w2ot,M.w1so,M.w2so "
                    . "FROM #__hockey_match M  "
                    . "LEFT JOIN #__hockey_teams T1 ON (M.druzyna1=T1.id) "
                    . "LEFT JOIN #__hockey_teams T2 ON (M.druzyna2=T2.id) "
                    . "WHERE M.published='1' AND M.type_of_match='0'"
                    . " AND M.id_system=" . $this->_db->Quote($this->_idsezon) . " AND M.id_kolejka=1"
                    . " ORDER BY M.data";
                $this->_list = $this->_getList($query, 0, 0);
                $this->_matchday = 1;
            }
        }
        return $this->_list;
    }
}
?>
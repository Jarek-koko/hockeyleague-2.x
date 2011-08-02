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

class HockeyModelStatsallteams extends JModel {

    
    private $_limit = 0;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function setLimit($limit) {
        $this->_limit = (int) $limit;
    }

    public function getListPlayers($id, $sez) {
        $query = "SELECT P.id,P.imie,P.nazwisko,P.foto,P.pozycja, T.name AS team,  "
                . "COALESCE(( SELECT COUNT(G.shooter) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =" . $this->_db->Quote($id) . " AND G.shooter = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0) AS bramki, "
                . "COALESCE(( SELECT COUNT(G.assist1) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =" . $this->_db->Quote($id) . " AND G.assist1 = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0) + "
                . "COALESCE(( SELECT COUNT(G.assist2) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =" . $this->_db->Quote($id) . " AND G.assist2 = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0)  AS asysty, "
                . "COALESCE(( SELECT COUNT(G.id_player) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_players  G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =" . $this->_db->Quote($id) . " AND G.id_player = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0)  AS mecze, "
                . "COALESCE(( SELECT COUNT(G.shooter) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =" . $this->_db->Quote($id) . " AND G.shooter = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0) + "
                . "COALESCE((SELECT COUNT(G.assist1) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =" . $this->_db->Quote($id) . " AND G.assist1 = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0) + "
                . "COALESCE(( SELECT COUNT(G.assist2) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =" . $this->_db->Quote($id) . " AND G.assist2 = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0)  AS punkty, "
                . "COALESCE(( SELECT SUM(G.time_p) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_penalty G ON (G.id_match = M.id) "
                . "WHERE (M.type_of_match =" . $this->_db->Quote($id) . " AND G.id_player = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0)  AS kary "
                . "FROM #__hockey_players AS P "
                . "LEFT JOIN  #__hockey_teams T  ON (T.id = P.klub) "
                . "WHERE (P.pozycja !=1 ) HAVING mecze <>'0' "
                . "ORDER BY punkty DESC , bramki DESC, mecze DESC";

        return $this->_getList($query, 0, $this->_limit );
    }

    public function getListGolies($id, $sez) {

        $query = "SELECT P.id,P.imie,P.nazwisko,P.foto,P.pozycja, T.name AS team,  "
                . "COALESCE(( SELECT sum(G.goals) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goalie G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =" . $this->_db->Quote($id) . " AND G.id_player = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0) AS total_goals, "
                . "COALESCE(( SELECT sum(G.save) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goalie G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =" . $this->_db->Quote($id) . " AND G.id_player = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0) AS total_save, "
                . "COALESCE(( SELECT sum(G.time_p) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goalie G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =" . $this->_db->Quote($id) . " AND G.id_player = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0) AS time_match, "
                . "COALESCE(( SELECT COUNT(G.shooter) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =" . $this->_db->Quote($id) . " AND G.shooter = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0) AS bramki, "
                . "COALESCE(( SELECT COUNT(G.assist1) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =" . $this->_db->Quote($id) . " AND G.assist1 = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0) + "
                . "COALESCE(( SELECT COUNT(G.assist2) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =" . $this->_db->Quote($id) . " AND G.assist2 = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0)  AS asysty, "
                . "COALESCE(( SELECT COUNT(G.id_player) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_players  G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =" . $this->_db->Quote($id) . " AND G.id_player = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0)  AS mecze, "
                . "COALESCE(( SELECT SUM(G.time_p) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_penalty G ON (G.id_match = M.id) "
                . "WHERE (M.type_of_match =" . $this->_db->Quote($id) . " AND G.id_player = P.id AND M.id_system=" . $this->_db->Quote($sez) . "  )),0)  AS kary "
                . "FROM #__hockey_players AS P "
                . "LEFT JOIN  #__hockey_teams T  ON (T.id = P.klub) "
                . "WHERE (P.pozycja=1 ) HAVING mecze <>'0' ";
        return $this->_getList($query, 0, $this->_limit );
    }
    
    public function getSezonList() {
        $query = 'SELECT id AS value, nazwa AS text FROM #__hockey_system ORDER BY id DESC;';
        $this->_db->setQuery($query);
        return $this->_db->loadObjectList();
    }
}

?>
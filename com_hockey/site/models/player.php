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

class HockeyModelPlayer extends JModel {

    private $_idteam = null;
    private $_idplayer = null;
    private $_player = null;
    private $_goalie = false;

    public function __construct() {
        parent::__construct();
        $this->_idplayer = (int) JRequest::getVar('id', 0, 'get', 'int');
    }

    public function getPlayer() {
        if (!$this->_player) {
            $query = "SELECT P.id,P.nazwisko,P.imie,P.pozycja,P.data_u,P.foto,P.wzrost ,P.waga, P.klubold ,P.klub, P.opis,P.nr, T.name "
                    . "FROM #__hockey_players P "
                    . "LEFT JOIN #__hockey_teams T ON  (T.id= P.klub) "
                    . "WHERE (P.id = " . $this->_db->Quote($this->_idplayer) . " )";
            $this->_db->setQuery($query);
            $this->_player = $this->_db->loadObject();
        }
        if ($this->_player != null) {
            if ($this->_player->pozycja == 1)
                $this->_goalie = true;
            $this->_idteam = $this->_player->klub;
        }
        return $this->_player;
    }

    public function getSelectPlayers() {
        $query = "SELECT id AS value, CONCAT_WS('. ',LEFT(imie,1),nazwisko) AS text "
                . "FROM #__hockey_players "
                . "WHERE published =1 AND klub=".$this->_idteam
                . " ORDER BY nazwisko";
        $this->_db->setQuery($query);
        return $this->_db->loadObjectList();
    }

    public function getStatplayer($i) {

        if ($this->_goalie) {
            $query = "SELECT S.nazwa, "
            . "COALESCE((SELECT SUM(G.goals) "
            . "FROM  #__hockey_match M "
            . "LEFT JOIN #__hockey_match_goalie G  ON (G.id_match = M.id) "
            . "WHERE (M.type_of_match =" . $this->_db->Quote($i) . " AND G.id_player=" . $this->_db->Quote($this->_idplayer) . " AND G.id_team = ".$this->_idteam." AND S.id =M.id_system) "
            . "GROUP BY M.id_system ),0) AS total_goals, "
            . "COALESCE((SELECT SUM(G.save) "
            . "FROM  #__hockey_match M "
            . "LEFT JOIN #__hockey_match_goalie G  ON (G.id_match = M.id) "
            . "WHERE (M.type_of_match =" . $this->_db->Quote($i) . " AND G.id_player=" . $this->_db->Quote($this->_idplayer) . " AND G.id_team = ".$this->_idteam." AND S.id =M.id_system) "
            . "GROUP BY M.id_system ),0) AS total_save, "
            . "COALESCE((SELECT SUM(G.time_p) "
            . "FROM  #__hockey_match M "
            . "LEFT JOIN #__hockey_match_goalie G  ON (G.id_match = M.id) "
            . "WHERE (M.type_of_match =" . $this->_db->Quote($i) . " AND G.id_player=" . $this->_db->Quote($this->_idplayer) . " AND G.id_team = ".$this->_idteam." AND S.id =M.id_system) "
            . "GROUP BY M.id_system ),0) AS time_match, "
            . "COALESCE((SELECT COUNT(G.shooter) "
            . "FROM  #__hockey_match M "
            . "LEFT JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
            . "WHERE (M.type_of_match =" . $this->_db->Quote($i) . " AND G.shooter=" . $this->_db->Quote($this->_idplayer) . " AND G.id_team = ".$this->_idteam." AND S.id =M.id_system)  "
            . "GROUP BY M.id_system),0) AS shoot, "
            . "COALESCE((SELECT COUNT(G.assist1) "
            . "FROM #__hockey_match M "
            . "LEFT JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
            . "WHERE (M.type_of_match =" . $this->_db->Quote($i) . " AND G.assist1=" . $this->_db->Quote($this->_idplayer) . " AND G.id_team = ".$this->_idteam." AND S.id =M.id_system) "
            . "GROUP BY M.id_system),0)+ "
            . "COALESCE((SELECT COUNT(G.assist2) "
            . "FROM #__hockey_match M "
            . "LEFT JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
            . "WHERE (M.type_of_match =" . $this->_db->Quote($i) . " AND G.assist2=" . $this->_db->Quote($this->_idplayer) . " AND G.id_team = ".$this->_idteam." AND S.id =M.id_system) "
            . "GROUP BY M.id_system),0) AS assist, "
            . "COALESCE((SELECT COUNT(P.id_player) "
            . "FROM #__hockey_match M "
            . "LEFT JOIN #__hockey_match_players P ON (P.id_match = M.id) "
            . "WHERE (M.type_of_match =" . $this->_db->Quote($i) . " AND P.id_player=" . $this->_db->Quote($this->_idplayer) . " AND P.id_team = ".$this->_idteam." AND S.id =M.id_system) "
            . "GROUP BY M.id_system),0) AS meczy, "
            . "COALESCE((SELECT SUM(P.time_p) "
            . "FROM #__hockey_match M "
            . "LEFT JOIN #__hockey_match_penalty P ON (P.id_match = M.id) "
            . "WHERE (M.type_of_match =" . $this->_db->Quote($i) . " AND P.id_player=" . $this->_db->Quote($this->_idplayer) . " AND P.id_team = ".$this->_idteam." AND S.id =M.id_system) "
            . "GROUP BY M.id_system),0) AS kary "
            . "FROM #__hockey_system S HAVING (meczy <> 0)";
        } else {
            $query = "SELECT S.nazwa, "
            . "COALESCE((SELECT COUNT(G.shooter) "
            . "FROM  #__hockey_match M "
            . "LEFT JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
            . "WHERE (M.type_of_match =" . $this->_db->Quote($i) . " AND G.shooter=" . $this->_db->Quote($this->_idplayer) . " AND G.id_team = ".$this->_idteam." AND S.id =M.id_system)  "
            . "GROUP BY M.id_system),0) AS shoot, "
            . "COALESCE((SELECT COUNT(G.assist1) "
            . "FROM #__hockey_match M "
            . "LEFT JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
            . "WHERE (M.type_of_match =" . $this->_db->Quote($i) . " AND G.assist1=" . $this->_db->Quote($this->_idplayer) . " AND G.id_team = ".$this->_idteam."  AND S.id =M.id_system) "
            . "GROUP BY M.id_system),0)+ "
            . "COALESCE((SELECT COUNT(G.assist2) "
            . "FROM #__hockey_match M "
            . "LEFT JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
            . "WHERE (M.type_of_match =" . $this->_db->Quote($i) . " AND G.assist2=" . $this->_db->Quote($this->_idplayer) . " AND G.id_team = ".$this->_idteam."  AND S.id =M.id_system) "
            . "GROUP BY M.id_system),0) AS assist, "
            . "COALESCE((SELECT COUNT(P.id_player) "
            . "FROM #__hockey_match M "
            . "LEFT JOIN #__hockey_match_players P ON (P.id_match = M.id) "
            . "WHERE (M.type_of_match =" . $this->_db->Quote($i) . " AND P.id_player=" . $this->_db->Quote($this->_idplayer) . " AND P.id_team = ".$this->_idteam." AND S.id =M.id_system) "
            . "GROUP BY M.id_system),0) AS meczy, "
            . "COALESCE((SELECT SUM(P.time_p) "
            . "FROM #__hockey_match M "
            . "LEFT JOIN #__hockey_match_penalty P ON (P.id_match = M.id) "
            . "WHERE (M.type_of_match =" . $this->_db->Quote($i) . " AND P.id_player=" . $this->_db->Quote($this->_idplayer) . " AND P.id_team = ".$this->_idteam." AND S.id =M.id_system) "
            . "GROUP BY M.id_system),0) AS kary "
            . "FROM #__hockey_system S HAVING (meczy <> 0) ";
        }
        return $this->_getList($query, 0, 0);
    }

}

?>
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

class HockeyModelModtop extends JModel {

    private $_idteam = "";

    public function __construct() {
        parent::__construct();
    }

    public function setIdteam($idteam) {
        
        if($idteam != 0) {
           $this->_idteam = " AND ( P.klub=". $this->_db->Quote($idteam) .") ";
        }
    }

    public function getTopPlayers($type, $sez, $nr) {

        switch ($nr) {
            case 3:
                $query = "SELECT P.id,concat_ws('. ',LEFT(P.imie,1),P.nazwisko) as nazwisko, "
                        . "COALESCE(( SELECT COUNT(G.assist1) "
                        . "FROM #__hockey_match M "
                        . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                        . "WHERE ( M.type_of_match =" . $this->_db->Quote($type) . " AND G.assist1 = P.id AND M.id_system=" . $this->_db->Quote($sez) . ")),0) + "
                        . "COALESCE(( SELECT COUNT(G.assist2) "
                        . "FROM #__hockey_match M "
                        . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                        . "WHERE ( M.type_of_match =" . $this->_db->Quote($type) . " AND G.assist2 = P.id AND M.id_system=" . $this->_db->Quote($sez) . ")),0)  AS asysty "
                        . "FROM #__hockey_players AS P "
                        . "WHERE ( P.published=1 ) AND (P.pozycja !=1 ) ".$this->_idteam
                        . "HAVING asysty <>'0'  ORDER BY asysty DESC LIMIT 10";
                break;
            case 2:
                $query = "SELECT P.id,concat_ws('. ',LEFT(P.imie,1),P.nazwisko) as nazwisko, "
                        . "COALESCE(( SELECT COUNT(G.shooter) "
                        . "FROM #__hockey_match M "
                        . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                        . "WHERE ( M.type_of_match =" . $this->_db->Quote($type) . " AND G.shooter = P.id AND M.id_system=" . $this->_db->Quote($sez) . ")),0) AS bramki "
                        . "FROM #__hockey_players AS P "
                        . "WHERE ( P.published=1 ) AND (P.pozycja !=1 ) ".$this->_idteam
                        . "HAVING bramki <>'0' ORDER BY bramki DESC LIMIT 10";
                break;
            default:
                $query = "SELECT P.id,concat_ws('. ',LEFT(P.imie,1),P.nazwisko) as nazwisko, "
                        . "COALESCE(( SELECT COUNT(G.shooter) "
                        . "FROM #__hockey_match M "
                        . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                        . "WHERE ( M.type_of_match =" . $this->_db->Quote($type) . " AND G.shooter = P.id AND M.id_system=" . $this->_db->Quote($sez) . ")),0) + "
                        . "COALESCE((SELECT COUNT(G.assist1) "
                        . "FROM #__hockey_match M "
                        . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                        . "WHERE ( M.type_of_match =" . $this->_db->Quote($type) . " AND G.assist1 = P.id AND M.id_system=" . $this->_db->Quote($sez) . ")),0) + "
                        . "COALESCE(( SELECT COUNT(G.assist2) "
                        . "FROM #__hockey_match M "
                        . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                        . "WHERE ( M.type_of_match =" . $this->_db->Quote($type) . " AND G.assist2 = P.id AND M.id_system=" . $this->_db->Quote($sez) . ")),0)  AS punkty "
                        . "FROM #__hockey_players AS P "
                        . "WHERE ( P.published=1 ) AND (P.pozycja !=1 )  ".$this->_idteam
                        . "HAVING punkty <>'0' ORDER BY punkty DESC LIMIT 10";
                break;
        }
        return $this->_getList($query, 0, 0);
    }

}

?>
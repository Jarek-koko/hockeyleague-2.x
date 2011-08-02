<?php
/*
 * @package Joomla 1.7
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @module Hockey League - Calendar
 * @copyright Copyright (C) Klich Jarosław
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
class modCalendarHelper {

    function getmatchdays($post_month, $post_year, &$params) {
        
        $idteam  = intval($params->get( 'idteam', '1' ));
        $sez = intval($params->get('sez', 0));
        $db = & JFactory::getDBO ();
        $query = "SELECT  m.data AS dates,( m.druzyna1 = " . $db->Quote($idteam) . ") AS home, DAYOFMONTH(m.data) AS matchday,m.id AS idmatch "
                . "FROM #__hockey_match m "
                . "WHERE (m.id_system=" . $db->Quote($sez) . ") "
                . "AND (MONTH(m.data)=" . $db->Quote($post_month) . ") "
                . "AND (YEAR(m.data)=" . $db->Quote($post_year) . ") "
                . "AND (m.published=1) AND ((m.druzyna1=" . $db->Quote($idteam) . ") OR (m.druzyna2=" . $db->Quote($idteam) . ")) "
                . "ORDER BY m.data";

        $db->setQuery($query);
        $events = $db->loadObjectList();
        $days = array();

        foreach ($events as $event) {
            if ($event->home == 1) {
                $bg = ' class="qhome" ';
            } else {
                $bg = ' class="qaway" ';
            }
            $data = $event->dates;
            $idmatch = $event->idmatch;
            $days [$event->matchday] = array($data, $bg, $idmatch);
        }
        return $days;
    }
}

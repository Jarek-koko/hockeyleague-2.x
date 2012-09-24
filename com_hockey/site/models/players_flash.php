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
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.model' );


class HockeyModelPlayers_flash extends JModel {

    function __construct() {
        parent::__construct ();      
    }
  
    function getListPlayers($idteam) {
        $query = "SELECT  *  FROM #__hockey_players "
        ."WHERE ( published=1 AND klub=".$this->_db->Quote($idteam).") "
        ."ORDER BY  nazwisko, imie";
        return $this->_getList ( $query, 0, 0 );
    }
}
?>
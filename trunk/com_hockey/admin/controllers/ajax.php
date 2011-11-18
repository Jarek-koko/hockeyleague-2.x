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
jimport('joomla.application.component.controller');

class HockeyControllerAjax extends JController {

    public function __construct($config = array()) {
        parent::__construct($config);
        JRequest::setVar('tmpl', 'component');
    }

    /* ajax for raport 3 -- goals 
     * display list of players
     */

    public function display() {
        $team = (int) JRequest::getVar('state', 0, 'get', 'int');

        if ($team == 0) {
            $players = array(array('id' => 'no', 'name' => JText::_('HOS_NO_PLAYERS')));
        } else {
            $db = & JFactory::getDBO();
            $query = "SELECT id , CONCAT_WS( ' ', nazwisko ,imie ) AS name "
                    . "FROM #__hockey_players "
                    . "WHERE klub=" . $db->Quote($team) . " AND published='1' ORDER BY nazwisko";

            $db->setQuery($query);
            $players = $db->loadAssocList();

            if (!count($players)) {
                $players = array(array('id' => 'no', 'name' => JText::_('HOS_NO_PLAYERS')));
            } 
            
            $document = & JFactory::getDocument();
            $document->setMimeEncoding('application/json');
            echo json_encode($players);
        }
    }

    /*
     * ajax for raport 
     * display list of players
     */

    public function getg() {
        $id_team = (int) JRequest::getVar('id_team', 0, 'get', 'int');
        if ($id_team == 0) {
             $players = array(array('id' => 'no', 'name' => JText::_('HOS_NO_PLAYERS')));
        } else {
            $db = & JFactory::getDBO();
            $query = "SELECT id , CONCAT_WS( ' ', nazwisko ,imie )AS name "
                    . "FROM #__hockey_players "
                    . "WHERE klub=" . $db->Quote($id_team) . " AND pozycja='1'  AND published ='1' ORDER BY  nazwisko ";

            $db->setQuery($query);
            $players = $db->loadAssocList();
            
            
            if (!count($players)) {
                $players = array(array('id' => 'no', 'name' => JText::_('HOS_NO_PLAYERS')));
            } 
            
            $document = & JFactory::getDocument();
            $document->setMimeEncoding('application/json');
            echo json_encode($players);
            
        }
    }

    /*
     * ajax for raport 
     * send json to display autocompleter 
     */

    public function iword() {
        $word = JRequest::getVar('value', '', 'post', 'string');

        if ($word != '') {
            $db = & JFactory::getDBO();
            $escape = $db->getEscaped($word);
            $escape = $db->Quote($escape . '%', false);
            $query = "SELECT note, COUNT(*)  FROM #__hockey_match_penalty WHERE note LIKE " . $escape . " GROUP BY note ORDER BY COUNT(*) DESC";
            $db->setQuery($query);
            $data = $db->loadResultArray();

            $document = & JFactory::getDocument();
            $document->setMimeEncoding('application/json');
            echo json_encode($data);
        }
    }

}

?>
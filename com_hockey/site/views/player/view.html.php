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
jimport('joomla.application.component.view');

class HockeyViewPlayer extends JView {

    function display($tpl = null) {

        $document = & JFactory::getDocument();
        $document->addScript(JURI::base(true) . '/components/com_hockey/assets/jquery.js');
        $document->addScript(JURI::base(true) . '/components/com_hockey/assets/jquery.tools.min.js');
        $idplayer = (int) JRequest::getVar('id', 0, 'get', 'int');

        if ($idplayer == 0) {
            JError::raiseError(404, JText::_("Player not found"));
            return;
        }

        $model = &$this->getModel();
        $player = $model->getPlayer();
        
        if (is_object($player)) {
            $regular_stat = $model->getStatplayer(0);
            $playoff_stat = $model->getStatplayer(1);
            $select_players = $model->getSelectPlayers();


            $document->setTitle($player->imie . ' ' . $player->nazwisko);

            $this->assignRef('idplayer', $idplayer);
            $this->assignRef('selpl', $select_players);
            $this->assignRef('playoff_stat', $playoff_stat);
            $this->assignRef('regular_stat', $regular_stat);
            $this->assignRef('player', $player);

            parent::display('select');
            parent::display($tpl);
        }
    }

}

?>
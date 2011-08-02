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

class HockeyViewStatsteam extends JView {

    function display($tpl = null) {

        $id = (int) JRequest::getVar('id', 0, 'get', 'INT');
        $app = JFactory::getApplication('site');
        $this->params = $app->getParams('com_hockey');
        $session = &JFactory::getSession();
        
        $sez = (int) $session->get('idsezon', 0);
        $idteam = (int) $this->params->get('idteam', 0);
        $show = (int) $this->params->get('show_select', 0);
        
        if (($sez == 0) || ($show == 0)) {
            $sez = $this->params->get('idseason', 0);
        }

        if (($sez == 0) || ($id == 0) || ($idteam == 0)) {
             echo '<div class="lmessage"><span>' . JText::_("Data not found") . '</span></div>';
            return;
        }
        $model = & $this->getModel();
        $model->setTeam($idteam);

        switch ($id) {
            case 4:
                $lista = $model->getListGolies(1, $sez);
                $title = JText::_('HOC_STAT_GOLIES_PLAYOFF');
                break;
            case 3:
                $lista = $model->getListGolies(0, $sez);
                $title = JText::_('HOC_STAT_GOLIES_SEASON_R');
                break;
            case 2:
                $lista = $model->getListPlayers(1, $sez);
                $title = JText::_('HOC_STAT_PLAYERS_PLAYOFF');
                break;
            default:
                $lista = $model->getListPlayers(0, $sez);
                $title = JText::_('HOC_STAT_PLAYERS_SEASON_R');
                break;
        }
        
        $this->assignRef('lista', $lista);
        $this->assignRef('title', $title);
        $this->assignRef('id', $id);
        parent::display('raw');
    }
}
?>
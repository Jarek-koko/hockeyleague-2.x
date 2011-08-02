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

class HockeyViewPlayers extends JView {

    protected $params;
    protected $team_name;

    public function display($tpl = null) {
        $document = & JFactory::getDocument();
        $document->addScript(JURI::base(true) . '/components/com_hockey/assets/jquery.js');
        $document->addScript(JURI::base(true) . '/components/com_hockey/assets/jquery.tablesorter.js');
        $document->addScript(JURI::base(true) . '/components/com_hockey/assets/tooltip.js');

        $u = & JURI::getInstance();
        $return = base64_encode($u->toString());

        $app = JFactory::getApplication('site');
        $this->params = $app->getParams('com_hockey');

        $model = &$this->getModel();
        $model->setTeam($this->params->get('idteam'));

        $this->team_name = $model->getNameTeam();
        $players = $model->getListPlayers();
        $position = array(
            '1' => JText::_('HOC_POSITION_GOALIES'),
            '2' => JText::_('HOC_POSITION_DEFENCEMENS'),
            '3' => JText::_('HOC_POSITION_FORWARDS')
        );

        $this->assignRef('team_name', $this->team_name);
        $this->assignRef('players', $players);
        $this->assignRef('position', $position);
        
        $this->_prepareDocument();
        parent::display($tpl);
    }

    protected function _prepareDocument() {

        $app = JFactory::getApplication();
        $menus = $app->getMenu();
        $title = null;

        $menu = $menus->getActive();
        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', $this->team_name.' '.JText::_('HOC_PLAYERS_TITLE'));
        }
        $title = $this->params->get('page_title', '');

        if (empty($title)) {
            $title = $app->getCfg('sitename');
        } elseif ($app->getCfg('sitename_pagetitles', 0)) {
            $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
        }
        $this->document->setTitle($title);

        if ($this->params->get('menu-meta_description')) {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('menu-meta_keywords')) {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        if ($this->params->get('robots')) {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }
    }
}

?>
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
require_once( JPATH_COMPONENT . DS . 'helpers' . DS . 'type.php' );

class HockeyViewReport4 extends JView {

    private $_type = null;

    public function display($tpl = null) {

        $document = & JFactory::getDocument();
        $document->addScript(JURI::root(true) . "/administrator/components/com_hockey/assets/Autocompleter.js");
        $document->addScript(JURI::root(true) . "/administrator/components/com_hockey/assets/Autocompleter.Request.js");
        $document->addScript(JURI::root(true) . "/administrator/components/com_hockey/assets/Observer.js");

        $id_match = (int) JRequest::getVar('id_match', 0, '', 'INT');
        $this->_type = (int) JRequest::getVar('type', 5, '', 'INT');
        $option = JRequest::getCmd('option');

        $model = &$this->getModel('reports');
        $items = $model->getPenalty($id_match);

        $model2 = &$this->getModel('teams');
        $team = $model2->getNameTeames($id_match);

        $sel [] = JHTML::_('select.option', 'no', JText::_('HOS_TEAMS_SELECT'));
        $sel [] = JHTML::_('select.option', $team ['team1'], $team ['druzyna1']);
        $sel [] = JHTML::_('select.option', $team ['team2'], $team ['druzyna2']);

        $this->assignRef('team', $team);
        $this->assignRef('items', $items);
        $this->assignRef('sel', $sel);
        $this->assignRef('id_match', $id_match);
        $this->assignRef('option', $option);
        $this->assignRef('type', $this->_type);

        $this->_addToolbar();
        $this->_addTitle();
        parent::display($tpl);
    }

    protected function _addToolbar() {
        $info = HockeyHelperSelectSeason::getNameSez();
        JToolBarHelper::title(JText::_('HOCKEY') . ' : ' . $info, 'logo.png');
        JToolBarHelper::custom('cancel', 'back.png', 'back.png', 'Back', false);
        JToolBarHelper::custom('remove', 'delete.png', 'delete.png', 'HOC_DEL_PENALTY', true);
        JToolBarHelper::custom('save', 'apply.png', 'apply.png', 'HOC_ADD_PENALTY', false);
    }

    protected function _addTitle() {
        $this->addTemplatePath(JPATH_COMPONENT_ADMINISTRATOR . DS . 'views' . DS . 'head');
        $title_type = HockeyHelperType::getT($this->_type);
        $title = JText::_('HOS_PENALTY_SUMMARY');
        $title = $title_type . ' - ' . $title;
        $this->assignRef('title', $title);
        parent::display('head');
    }
}
?>

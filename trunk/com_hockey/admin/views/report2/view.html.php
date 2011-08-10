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

class HockeyViewReport2 extends JView {

    private $_type = null;

    public function display($tpl = null) {

        JHTML::_( 'behavior.mootools' );
        $document = & JFactory::getDocument();
        $document->addScript(JURI::root(true) . "/administrator/components/com_hockey/assets/moocheck.js");
        
        $id_match = (int) JRequest::getVar('id_match', 0, 'get', 'INT');
        $this->_type = (int) JRequest::getVar('type', 5, '', 'INT');
        $option = JRequest::getCmd('option');
        $model1 = &$this->getModel('teams');
        $druzyna = $model1->getNameTeames($id_match);

        $model2 = &$this->getModel('reports');
        $items = $model2->getPlayers($id_match, $druzyna ['team1'], $druzyna ['team2']);

        $this->assignRef('items', $items);
        $this->assignRef('druzyna', $druzyna);
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
        JToolBarHelper::custom('cancel', 'back.png', 'back.png', 'back', false);
        JToolBarHelper::save();
    }

    protected function _addTitle() {
        $this->addTemplatePath(JPATH_COMPONENT_ADMINISTRATOR . DS . 'views' . DS . 'head');
        $title_type = HockeyHelperType::getT($this->_type);
        $title = JText::_('HOS_RAPPORT_MATCHE');
        $title = $title_type . ' - ' . $title;
        $this->assignRef('title', $title);
        parent::display('head');
    }

}

?>

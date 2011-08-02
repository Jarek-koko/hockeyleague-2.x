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

    public function display($tpl = null) {

        $uri = & JFactory::getURI();
        $option = JRequest::getCmd('option');
        $mainframe = &JFactory::getApplication();

        $filter_custom = $mainframe->getUserStateFromRequest($option . 'filter_custom', 'filter_custom', '', 'string');
        $search = $mainframe->getUserStateFromRequest($option . 'search', 'search', '', 'string');
        $search = JString::strtolower($search);

        //get data from model players
        $items = & $this->get('Data');
        $pagination = & $this->get('Pagination');

        //get data from model teams
        $model = & $this->getModel('teams');
        $kluby = & $model->getAllTeamsSelect();

        // create filtrs 
        $js = " onchange=\"if (this.options[selectedIndex].value!=''){ document.adminForm.submit(); }\" ";
        $lists ['custom'] = JHTML::_('select.genericlist', $kluby, 'filter_custom', 'class="inputbox" ' . $js, 'value', 'text', $filter_custom);
        $lists['search'] = $search;

        $this->assignRef('lists', $lists);
        $this->assignRef('items', $items);
        $this->assignRef('option', $option);
        $this->assignRef('pagination', $pagination);
        $this->assignRef('request_url', $uri->toString());

        $this->addToolbar();
        $this->addTitle();
        parent::display($tpl);
    }

    protected function addToolbar() {
        $info = HockeyHelperSelectSeason::getNameSez();
        JToolBarHelper::title(JText::_('HOCKEY') . ' : ' . $info, 'logo.png');
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::editList();
        JToolBarHelper::deleteList('HOC_QUESTION');
        JToolBarHelper::addNew();
    }

    protected function addTitle() {
        $this->addTemplatePath(JPATH_COMPONENT_ADMINISTRATOR . DS . 'views' . DS . 'head');
        $title = JText::_('PLAYERS');
        $this->assignRef('title', $title);
        parent::display('head');
    }

}

?>

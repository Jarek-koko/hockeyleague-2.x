<?php

/*
 * @package Joomla 1.6
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Hockey
 * @copyright Copyright (C) Klich Jarosław
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class HockeyViewSezons extends JView {

    public function display($tpl = null) {

        $uri = & JFactory::getURI();
        $option = JRequest::getCmd('option');

        $items = & $this->get('Data');
        $pagination = & $this->get('Pagination');

        $this->assignRef('request_url', $uri->toString());
        $this->assignRef('pagination', $pagination);
        $this->assignRef('items', $items);
        $this->assignRef('option', $option);

        $this->_addToolbar();
        $this->_addTitle();
        parent::display($tpl);
    }

    protected  function _addToolbar() {
        JToolBarHelper::title(JText::_('HOCKEY'), 'logo.png');
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::editList();
        JToolBarHelper::deleteList('HOC_QUESTION');
        JToolBarHelper::addNew();
    }

    protected  function _addTitle() {
        $this->addTemplatePath(JPATH_COMPONENT_ADMINISTRATOR . DS . 'views' . DS . 'head');
        $title = JText::_('SEASON');
        $this->assignRef('title', $title);
        parent::display('head');
    }

}
?>


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

class HockeyViewLeagues extends JView {

    public function display($tpl = null) {

        $uri = & JFactory::getURI();
        $option = JRequest::getCmd('option');
        $mainframe = &JFactory::getApplication();
        // get model
        $model = &$this->getModel('matches');
        // list matchday
        $listakol = $model->getListMatchday(0);
        // nr matchday selected
        $nr_kol = (int) $mainframe->getUserStateFromRequest($option . 'nrrrkol', 'nrrrkol', '', 'int');

        // if nr matchay is not select then get first
        if ($listakol) {
            $nr_kol = (in_array($nr_kol, $listakol) ? $nr_kol : $listakol[0]);
        }

        // list matches in matchday
        $items = $model->getListMatches($nr_kol, 0);

        $this->assignRef('nr_kol', $nr_kol);
        $this->assignRef('listakol', $listakol);
        $this->assignRef('items', $items);
        $this->assignRef('option', $option);
        $this->assignRef('request_url', $uri->toString());
        $this->_addToolbar();
        $this->_addTitle();
        parent::display($tpl);
    }

    protected function _addToolbar() {
        $info = HockeyHelperSelectSeason::getNameSez();
        JToolBarHelper::title(JText::_('HOCKEY') . ' : ' . $info, 'logo.png');
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::deleteList('HOC_QUESTION');
        JToolBarHelper::editList();
        JToolBarHelper::addNew();
   
        // sepecial button for other controler matchday
        $alt = JText::_('HOC_ADD_MACHDAYS');
        $bar = & JToolBar::getInstance('toolbar');
        $herf = JRoute::_('index.php?option=com_hockey&view=matchday');
        $bar->appendButton('Link', 'multiple', $alt, $herf);
    }

    protected function _addTitle() {
        $this->addTemplatePath(JPATH_COMPONENT_ADMINISTRATOR . DS . 'views' . DS . 'head');
        $title = JText::_('MATCHES');
        $this->assignRef('title', $title);
        parent::display('head');
    }
}
?>

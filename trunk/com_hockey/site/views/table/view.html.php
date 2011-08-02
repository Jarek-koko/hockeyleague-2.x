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
JHTML::addIncludePath(JPATH_COMPONENT . DS . 'helpers');

class HockeyViewTable extends JView {
    
    
    protected $return_page;
    protected $params;

    public function display($tpl = null) {

        $document = & JFactory::getDocument();
        $document->addScript(JURI::base(true) . '/components/com_hockey/assets/jquery.js');
        $document->addScript(JURI::base(true) . '/components/com_hockey/assets/jquery.tablesorter.js');
        
        $u =& JURI::getInstance();
        $this->return_page = base64_encode($u->toString());
      
        $model = &$this->getModel();
        $app = JFactory::getApplication('site');
        $this->params = $app->getParams('com_hockey');
        $model->setSezon($this->params->get('idseason'), $this->params->get('show_select'));

        //get list teams for table
        $list = $model->getData();
        // get season for select
        $sezony = $model->getSezonList();

        $lista = JHTML::_('select.genericlist', $sezony, 'sezon', 'class="inputbox" ', 'value', 'text', $model->getSezon());
        // helper selectseason
        $select_season = JHTML::_('Selectseason.getSelect', $lista, $this->return_page, JRoute::_('index.php?option=com_hockey&task=querypost'));
        $infosezon = $model->getInfoSezon();
      
        $this->assignRef('list', $list);
        $this->assignRef('params', $this->params);
        $this->assignRef('infosezon', $infosezon);
        $this->assignRef('select_season', $select_season);
        
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
            $this->params->def('page_heading', JText::_('HOC_TABLE_TITLE'));
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
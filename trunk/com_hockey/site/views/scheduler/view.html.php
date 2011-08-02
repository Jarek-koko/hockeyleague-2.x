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

class HockeyViewScheduler extends JView {
    
       protected $return_page;
       protected $params;

    function display($tpl = null) {
      
        $document = & JFactory::getDocument();
        $document->addScript(JURI::base(true) . '/components/com_hockey/assets/jquery.js');
        $app = JFactory::getApplication('site');
        $this->params = $app->getParams('com_hockey');
        
        $model = &$this->getModel();
        $model->setSezon($this->params->get('idseason'),$this->params->get('show_select'));
        
        $u =& JURI::getInstance();
        $this->return_page = base64_encode($u->toString());
    
        // list matchday
        $list = $model->getListMatchday();
        // list matches in matchday
        $rows = $model->getListMatches();
        // list season
        $sezony = $model->getData();
        $nr = count($sezony);

        if ($nr < 1) {
            JError::raiseWarning(403, JText::_('HOC_NO_SEASON'));
            return;
        }
        for ($a = 0; $a < $nr; $a++) {
            if ($sezony[$a]->value == $model->getSezon()) {
                $name_season = $sezony[$a]->text;
            }
        }

        $lista = JHTML::_('select.genericlist', $sezony, 'sezon', 'class="inputbox" size="1"', 'value', 'text', $model->getSezon());
        $select_season = JHTML::_('Selectseason.getSelect', $lista,  $this->return_page , JRoute::_('index.php?option=com_hockey&task=querypost'));

        $this->assignRef('list', $list);
        $this->assignRef('rows', $rows);
        $this->assignRef('matchday',$model->getMatchday());
        $this->assignRef('params', $this->params);
        $this->assignRef('return', $this->return_page);
        $this->assignRef('name_season', $name_season);
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
            $this->params->def('page_heading',JText::_('HOC_SCHEDULER_TITLE'));
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
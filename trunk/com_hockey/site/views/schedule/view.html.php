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

class HockeyViewSchedule extends JView {

  public function display($tpl = null) {
      
        $model = &$this->getModel();
        $app = JFactory::getApplication('site');
        $this->params = $app->getParams('com_hockey');
        $model->setSezon($this->params->get('idseason'));
        $sezony = $model->getData();
        
        $u =& JURI::getInstance();
        $return = base64_encode($u->toString());
        
        $nr = count($sezony);
        if ($nr < 1) {
            JError::raiseWarning(403, JText::_('HOC_NO_SEASON'));
            return;
        }
        
        $idseason = $model->getSezon();
        $idteam =  (int) $this->params->get('idteam');
        
        for ($a = 0; $a < $nr; $a++) {
            if ($sezony[$a]->value == $idseason) {
                $name_season = $sezony[$a]->text;
            }
        }
      
        $rows = $model->getAList($idteam);
        $lista = JHTML::_('select.genericlist', $sezony, 'sezon', 'class="inputbox size="1" ', 'value', 'text', $idseason);

        $stom = array();
        $stom[] = JHTML::_('select.option', '0', JText::_('HOC_REGULAR_SEASON_SELECT'));
        $stom[] = JHTML::_('select.option', '1', JText::_('HOC_PLAYOFF_SELECT'));
        $stom[] = JHTML::_('select.option', '2', JText::_('HOC_PRESEASON_SELECT'));
        $tom = JHTML::_('select.genericlist', $stom, 'tom', 'class="inputbox" size="1" ', 'value', 'text', $model->getTom());
        
        if ($idteam != 0 ) {
            $re = array();
            $re[] = JHTML::_('select.option', '0', JText::_('HOC_ALL_GAMES'));
            $re[] = JHTML::_('select.option', '1', JText::_('HOC_HOME_GAMES'));
            $re[] = JHTML::_('select.option', '2', JText::_('HOC_AWAY_GAMES'));
            $where = JHTML::_('select.genericlist', $re, 'where', 'class="inputbox" size="1" ', 'value', 'text', $model->getWhere());
            $this->assignRef('where', $where);
        }
        $this->assignRef('tom', $tom);
        $this->assignRef('rows', $rows);
        $this->assignRef('idsezon', $model->getSezon());
        $this->assignRef('params', $this->params);
        $this->assignRef('name_season', $name_season);
        $this->assignRef('lista', $lista);
        $this->assignRef('return', $return);
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
            $this->params->def('page_heading', JText::_('HOC_SCHEDULEALL_TITLE'));
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
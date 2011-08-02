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

class HockeyViewLive extends JView {

    protected $params;

    public function display($tpl = null) {

        $document = & JFactory::getDocument();
        $document->addScript(JURI::base(true) . '/components/com_hockey/assets/jquery.js');
        $app = JFactory::getApplication('site');
        $this->params = $app->getParams('com_hockey');

      
        $id_match = (int) $this->params->get('id_match', 0);
        $message1 = $this->params->get('message1', 'no match');
        $time = (int) $this->params->get('time');
        $time = (1000 * $time);

        if ($id_match == 0) {
            echo '<div class="lmessage"><span>' . $message1 . '</span></div>';
            return;
        }

        $this->assignRef('time', $time);
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
            $this->params->def('page_heading', $this->params->get('titlehead'));
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
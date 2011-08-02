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
jimport('joomla.application.component.controller');

class HockeyController extends JController {

    public function display() {
        if (!JRequest::getCmd('view')) {
            JRequest::setVar('view', 'table');
        }
        $document = &JFactory::getDocument();
        $document->addStyleSheet(JURI::base(true) . '/components/com_hockey/assets/style.css');
        parent::display();
    }

    // get query post from helper selectseason
    // work with raports, table, stats, schedule-r-p,
    public function querypost() {
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        $return = JRequest::getVar('return', null, 'default', 'base64');
        $return = base64_decode($return);
        if (!JUri::isInternal($return)) {
            $return = null;
        }
        $idsezon = (int) JRequest::getVar('sezon', 0, 'post', 'int');
        $session = &JFactory::getSession();
        $session->set('idsezon', $idsezon);
        $session->clear('matchday');
        $this->setRedirect($return);
    }

    // get query post from square id_matchday
    // work only with scheduler
    public function querypost2() {
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));       
        $return = JRequest::getVar('return', null, 'default', 'base64');
        $return = base64_decode($return);
        if (!JUri::isInternal($return)) {
            $return = null;
        }
        $matchday = (int) JRequest::getVar('matchday', 0, 'post', 'int');
        $session = &JFactory::getSession();
        $session->set('matchday', $matchday);
        $this->setRedirect($return);
    }

    // get query post from schedule
    // work only with schedule
    public function querypost3() {
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        $return = JRequest::getVar('return', null, 'default', 'base64');
        $return = base64_decode($return);
        if (!JUri::isInternal($return)) {
            $return = null;
        }
        
        $idsezon = (int) JRequest::getVar('sezon', 0, 'post', 'int');
        $tom = (int) JRequest::getVar('tom', 0, 'post', 'int');
        $where = (int) JRequest::getVar('where', 0, 'post', 'int');
        $session = &JFactory::getSession();
        $session->set('idsezon', $idsezon);
        $session->set('tom', $tom);
        $session->set('where', $where);
        $this->setRedirect($return);
    }
}

?>
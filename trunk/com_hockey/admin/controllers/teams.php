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
jimport('joomla.application.component.controller');

class HockeyControllerTeams extends JController {

    private $_option = null;

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->registerTask('add', 'edit');
        $this->registerTask('apply', 'save');
        $this->registerTask('unpublish', 'publish');
        $this->_option = JRequest::getCmd('option');
    }

    public function display() {
        $view = JRequest::getVar('view');
        if (!$view) {
            JRequest::setVar('view', 'teams');
        }
        parent::display();
    }

    public function edit() {
        JRequest::setVar('hidemainmenu', 1);
        $view = & $this->getView('Team', 'html');
        $model = & $this->getModel('teams');
        $view->setModel($model, true);
        $view->display();
    }
    
    public function save2new(){
        JRequest::checkToken() or jexit('Invalid Token'); 
        $model = $this->getModel('teams');       
        if ($model->store()) {
            $msg = JText::_('Item Saved');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }  
        $link = 'index.php?option=' . $this->_option . '&view=teams&task=edit';
        $this->setRedirect($link, $msg, $type);
        
    }
    
    public function save() {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('teams');
        if ($model->store()) {
            $msg = JText::_('Item Saved');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }

        $task = JRequest::getCmd('task');
        switch ($task) {
            case 'apply' :
                $link = 'index.php?option=' . $this->_option . '&view=teams&task=edit&cid[]=' . $model->getId();
                break;

            case 'save' :
            default :
                $link = 'index.php?option=' . $this->_option . '&view=teams';
                break;
        }
        $this->setRedirect($link, $msg, $type);
    }

    public function remove() {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('teams');
        if ($model->delete()) {
            $msg = JText::_('Items removed');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }
        $link = 'index.php?option=' . $this->_option . '&view=teams';
        $this->setRedirect($link, $msg, $type);
    }

    public function publish() {
        JRequest::checkToken() or jexit('Invalid Token');
        $cid = JRequest::getVar('cid', array(0), '', 'array');
        JArrayHelper::toInteger($cid, array(0));
        $publish = ( $this->getTask() == 'publish' ? 1 : 0 );

        JTable::addIncludePath(JPATH_COMPONENT . DS . 'tables');
        $row = & JTable::getInstance('teams', 'Table');

        if (!$row->publish($cid, $publish)) {
            return JError::raiseWarning(500, $row->getError());
        }
        $this->setRedirect('index.php?option=' . $this->_option . '&view=teams');
    }

    public function cancel() {

        $this->setRedirect('index.php?option=' . $this->_option . '&view=teams');
    }

}

?>
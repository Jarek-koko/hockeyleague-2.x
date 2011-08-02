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

class HockeyControllerSparring extends MainController {

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->registerTask('apply', 'save');
        $this->registerTask('add', 'edit');
        $this->registerTask('unpublish', 'publish');
        $this->verSez();
    }

    public function display() {
        $view = & $this->getView('sparrings', 'html');
        $model = & $this->getModel('matches');
        $view->setModel($model, true);
        $view->display();
    }

    public function edit() {
        JRequest::setVar('hidemainmenu', 1);
        $view = & $this->getView('sparring', 'html');
        $model1 = & $this->getModel('matches');
        $model2 = & $this->getModel('teams');
        $view->setModel($model1, true);
        $view->setModel($model2, false);
        $view->setLayout('edit');
        $view->display();
    }
    
    public function save2new(){
        JRequest::checkToken() or jexit('Invalid Token'); 
        $model = $this->getModel('matches');       
        if ($model->store()) {
            $msg = JText::_('Item Saved');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }  
        $link = 'index.php?option=' . $this->_option . '&view=sparring&task=add';
        $this->setRedirect($link, $msg, $type); 
    }
    
    public function save() {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('matches');
        if ($model->store()) {
            $msg = JText::_('Item Saved');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }
        $link = 'index.php?option=' . $this->_option . '&view=sparring';
        $this->setRedirect($link, $msg, $type);
    }

    public function remove() {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('matches');
        if ($model->delete()) {
            $msg = JText::_('Items removed');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }
        $link = 'index.php?option=' . $this->_option . '&view=sparring';
        $this->setRedirect($link, $msg, $type);
    }

    public function publish() {
        JRequest::checkToken() or jexit('Invalid Token');
        $cid = JRequest::getVar('cid', array(0), '', 'array');
        JArrayHelper::toInteger($cid, array(0));

        $publish = ( $this->getTask() == 'publish' ? 1 : 0 );

        JTable::addIncludePath(JPATH_COMPONENT . DS . 'tables');
        $row = & JTable::getInstance('match', 'Table');

        if (!$row->publish($cid, $publish)) {
            return JError::raiseError(500, $row->getError());
        }
        $this->setRedirect('index.php?option=' . $this->_option . '&view=sparring');
    }

    public function cancel() {
        $this->setRedirect('index.php?option=' . $this->_option . '&view=sparring');
    }

}

?>

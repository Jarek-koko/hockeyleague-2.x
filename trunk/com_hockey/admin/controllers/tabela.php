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
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.controller' );


class HockeyControllerTabela extends MainController {


    public function __construct($config = array()) {
        parent::__construct ( $config );
        $this->registerTask ( 'add', 'edit' );
        $this->registerTask ( 'apply', 'save' );
        $this->registerTask ( 'unpublish', 'publish' );
        $this->verSez();
    }

    public function  display() {
       $view = JRequest::getVar('view');
        if (!$view) {
                JRequest::setVar('view', 'tabela');
        }
        parent::display();
    }

    public function edit() {
     JRequest::setVar('hidemainmenu', 1);
     $view = & $this->getView('tabelaitem', 'html');
     $model1 = & $this->getModel('tabela');
     $model2 = & $this->getModel('teams');
     $view->setModel($model1, true);
     $view->setModel($model2, false);
     $view->display();
    }
    
    public function save2new(){
        JRequest::checkToken() or jexit('Invalid Token'); 
        $model = $this->getModel('tabela');       
        if ($model->store()) {
            $msg = JText::_('Item Saved');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }  
        $link = 'index.php?option=' . $this->_option . '&view=tabela&task=edit';
        $this->setRedirect($link, $msg, $type); 
    }
    
    public function save() {
       JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('tabela');
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
                $link = 'index.php?option=' . $this->_option . '&view=tabela&task=edit&cid[]=' . $model->getId();
                break;

            case 'save' :
            default :
                $link = 'index.php?option=' . $this->_option . '&view=tabela';
                break;
        }
        $this->setRedirect($link, $msg, $type);
    }

    public function savegruporder() {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('tabela');
        if ($model->ordergrup()) {
            $msg = JText::_ ( 'New ordering saved' );
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }
        
        $link = 'index.php?option=' . $this->_option . '&view=tabela';
        $this->setRedirect($link, $msg, $type);
        
    }

    public function saveorder() {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('tabela');
        if ($model->order()) {
            $msg = JText::_ ( 'New ordering saved' );
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }
        
        $link = 'index.php?option=' . $this->_option . '&view=tabela';
        $this->setRedirect($link, $msg, $type);
    }

    public function remove() {
       JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('tabela');
        if ($model->delete()) {
            $msg = JText::_('Items removed');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }
        $link = 'index.php?option=' . $this->_option . '&view=tabela';
        $this->setRedirect($link, $msg, $type);
    }

    public function publish() {
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $cid = JRequest::getVar ( 'cid', array (0), '', 'array' );
        JArrayHelper::toInteger( $cid );

        $publish = ( $this->getTask() == 'publish' ? 1 : 0 );

        JTable::addIncludePath ( JPATH_COMPONENT . DS . 'tables' );
        $row = & JTable::getInstance ( 'tabela', 'Table' );

        if (! $row->publish ( $cid, $publish )) {
            return JError::raiseError ( 500, $row->getError());
        }
        $this->setRedirect ( 'index.php?option=' . $this->_option . '&view=tabela' );
    }

    public function cancel() {
       $this->setRedirect('index.php?option=' . $this->_option . '&view=tabela');
    }
}
?>
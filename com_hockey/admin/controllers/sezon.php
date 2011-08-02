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

class HockeyControllerSezon extends JController {

    private $_option = null;

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->registerTask('unpublish', 'publish');
        $this->registerTask('add', 'edit');
        $this->_option = JRequest::getCmd('option');
    }

    public function display() {
        $view = & $this->getView('Sezons', 'html');
        $model = & $this->getModel('sezon');
        $view->setModel($model, true);
        $view->display();
    }

    public function edit() {
        JRequest::setVar('hidemainmenu', 1);
        $view = & $this->getView('Sezon', 'html');
        $model = & $this->getModel('sezon');
        $view->setModel($model, true);
        $view->display();
    }

    public function save() {
        JRequest::checkToken() or jexit('Invalid Token');

        $model = $this->getModel('sezon');
        if ($model->store()) {
            $msg = JText::_('HOC_HOA_MSG_SUCESS_SEASON');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }
        $link = 'index.php?option=' . $this->_option . '&view=sezon';
        $this->setRedirect($link, $msg, $type);
    }

    public function publish() {
        JRequest::checkToken() or jexit('Invalid Token');

        $cid = JRequest::getVar('cid', array(0), '', 'array');
        $publish = ( $this->getTask() == 'publish' ? 1 : 0 );

        JTable::addIncludePath(JPATH_COMPONENT . DS . 'tables');
        $row = & JTable::getInstance('sezon', 'Table');

        if (!$row->publish($cid, $publish)) {
            return JError::raiseError(500, $row->getError());
        }
        $this->setRedirect('index.php?option=' . $this->_option . '&view=sezon');
    }

    public function remove() {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('sezon');
        if ($model->delete()) {
            $msg = JText::_('HOC_HOA_MSG_SUCESS_DELETE');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }

        $link = 'index.php?option=' . $this->_option . '&view=sezon';
        $this->setRedirect($link, $msg, $type);
    }

    public function cancel() {
        $this->setRedirect('index.php?option=' . $this->_option . '&view=sezon');
    }
}
?>
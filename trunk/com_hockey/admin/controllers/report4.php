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

class HockeyControllerReport4 extends MainController {

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->verSez();
        $this->setTypePage();
        $this->verIdMatch();
    }

    public function display() {
        JRequest::setVar('hidemainmenu', 1);
        $view = & $this->getView('report4', 'html');
        $model1 = & $this->getModel('reports');
        $model2 = & $this->getModel('teams');
        $view->setModel($model1, true);
        $view->setModel($model2, false);
        $view->display();
    }

    public function save() {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('reports');

        if ($model->storeReport4()) {
            $msg = JText::_('Item Saved');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }

        $link = 'index.php?option=' . $this->_option . '&view=report4&type=' . $this->_type . '&id_match=' . $this->_id_match;
        $this->setRedirect($link, $msg, $type);
    }

    public function remove() {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('reports');
        if ($model->deleteReport4()) {
            $msg = JText::_('Items removed');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }

        $link = 'index.php?option=' . $this->_option . '&view=report4&type=' . $this->_type . '&id_match=' . $this->_id_match;
        $this->setRedirect($link, $msg, $type);
    }

}

?>
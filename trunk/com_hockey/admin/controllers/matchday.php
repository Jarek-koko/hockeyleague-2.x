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

class HockeyControllerMatchday extends MainController {

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->verSez();
    }

    public function display() {
        JRequest::setVar('hidemainmenu', 1);
        $view = & $this->getView('matchdays', 'html');
        $model1 = & $this->getModel('matches');
        $model2 = & $this->getModel('teams');
        $view->setModel($model1, true);
        $view->setModel($model2, false);
        $view->setLayout('add');
        $view->display();
    }

    public function edit() {
        JRequest::checkToken() or jexit('Invalid Token');
        JRequest::setVar('hidemainmenu', 1);
        $view = & $this->getView('matchday', 'html');
        $model1 = & $this->getModel('matches');
        $model2 = & $this->getModel('teams');
        $view->setModel($model1, true);
        $view->setModel($model2, false);
        $view->setLayout('addnext');
        $view->display();
    }

    public function save() {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('matches');
        if ($model->multistore()) {
            $msg = JText::_('Item Saved');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }
        $link = 'index.php?option='.$this->_option.'&view=league';
        $this->setRedirect($link, $msg, $type);
    }

    public function cancel() {
        $this->setRedirect('index.php?option='.$this->_option.'&view=league');
    }

}

?>

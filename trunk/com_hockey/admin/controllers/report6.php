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

class HockeyControllerReport6 extends MainController {

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->verSez();
        $this->setTypePage();
        $this->verIdMatch();
    }

    public function display() {
        JRequest::setVar('hidemainmenu', 1);
        $view = & $this->getView('report6', 'html');
        $model1 = & $this->getModel('reports');
        $view->setModel($model1, true);
        $view->display();
    }

    public function save() {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('reports');

        if ($model->storeReport6()) {
            $msg = JText::_('Item Saved');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }
        $link = 'index.php?option=' . $this->_option . '&view=' . $this->_page;
        $this->setRedirect($link, $msg, $type);
    }

}

?>
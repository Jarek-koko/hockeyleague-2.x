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

class HockeyControllerInfo extends JController {

    public function __construct($config = array()) {
        parent::__construct($config);
    }

    public function display() {

        $view = JRequest::getVar('view');
        if (!$view) {
            JRequest::setVar('view', 'info');
        }
        parent::display();
    }
}
?>
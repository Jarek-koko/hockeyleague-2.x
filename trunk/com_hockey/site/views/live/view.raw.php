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
jimport('joomla.filesystem.file');

class HockeyViewLive extends JView {

    protected $params;

    public function display($tpl = null) {

        $app = JFactory::getApplication('site');
        $this->params = $app->getParams('com_hockey');
        $id_match = (int) $this->params->get('id_match', 0);
        $end = (int) $this->params->get('end', 0);

        if ($id_match == 0) {
            return;
        }

         
        $document =& JFactory::getDocument();
        $document->setMimeEncoding('text/plain');
        $model = &$this->getModel();
        $model->setId($id_match);
        $list = $model->getList();

        if (count($list)) {
            $zawodnicy = $model->getPlayers();
            $gole = $model->getGoals();
            $penalty = $model->getPenalty();

            $this->assignRef('end', $end);
            $this->assignRef('gole', $gole);
            $this->assignRef('penalty', $penalty);
            $this->assignRef('zawodnicy', $zawodnicy);
            $this->assignRef('list', $list);
            parent::display('raw');
        }
    }
}
?>



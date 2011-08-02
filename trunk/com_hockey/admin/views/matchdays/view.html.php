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

class HockeyViewMatchdays extends JView {

    public function display($tpl = null) {

        $uri = & JFactory::getURI();
        $option = JRequest::getCmd('option');
        $mainframe = &JFactory::getApplication();

        $model = &$this->getModel('matches');
        $liczba_k = $model->getLastMatchday(0);
        $liczba_k++;

        for ($i = 1; $i <= $liczba_k; $i++) {
            $kl [] = JHTML::_('select.option', $i);
        }
        $lists ['kolejka_nr'] = JHTML::_('select.genericList', $kl, 'kolejka_nr', 'class="inputbox"', 'value', 'text', $liczba_k);

        $model = &$this->getModel('teams');
        $liczba_d = $model->getSeasonTeamsSelect();
        $liczba_d = ceil((count($liczba_d) / 2));

        for ($i = 1; $i <= $liczba_d; $i++) {
            $kk [] = JHTML::_('select.option', $i);
        }
        $lists ['liczba_s'] = JHTML::_('select.genericList', $kk, 'liczba_s', 'class="inputbox"', 'value', 'text', $liczba_d);

        $this->assignRef('lists', $lists);
        $this->assignRef('option', $option);
        $this->assignRef('request_url', $uri->toString());
        $this->_addToolbar();
        parent::display($tpl);
    }

    protected function _addToolbar() {
        $info = HockeyHelperSelectSeason::getNameSez();
        JToolBarHelper::title(JText::_('HOCKEY') . ' : ' . $info, 'logo.png');
        JToolBarHelper::custom('edit', 'forward.png', 'forward.png', 'HOC_NEXT', false);
        JToolBarHelper::cancel();
    }
}

?>

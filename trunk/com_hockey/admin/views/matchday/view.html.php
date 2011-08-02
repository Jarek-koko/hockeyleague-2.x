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

class HockeyViewMatchday extends JView {

  
    public function display($tpl = null) {

        $uri = & JFactory::getURI();
        $option = JRequest::getCmd('option');
        $mainframe = &JFactory::getApplication();

        $kolejka_nr = (int) JRequest::getVar('kolejka_nr', 0, 'post', 'INT');
        $liczba_s = (int) JRequest::getVar('liczba_s', 0, 'post', 'INT');
        $data = JRequest::getVar('data', '', 'post', 'STRING');

        if (($kolejka_nr == 0) || ($liczba_s == 0)) {
            $link = 'index.php?option=' . $option . '&view=league';
            $type = 'notice';
            $msg = JText::_('HOA_MUST_NR_MACHEDAY');
            $mainframe->redirect($link, $msg, $type);
        } else {
            $model = &$this->getModel('teams');
            $kl = $model->getSeasonTeamsSelect(1);

            $this->assignRef('kl', $kl);
            $this->assignRef('kolejka_nr', $kolejka_nr);
            $this->assignRef('liczba_s', $liczba_s);
            $this->assignRef('data', $data);
            $this->assignRef('option', $option);
            $this->assignRef('request_url', $uri->toString());
            $this->_addToolbar();
            parent::display($tpl);
        }
    }

    protected function _addToolbar() {
        $info = HockeyHelperSelectSeason::getNameSez();
        JToolBarHelper::title(JText::_('HOCKEY') . ' : ' . $info, 'logo.png');
        JToolBarHelper::save();
        JToolBarHelper::cancel();
    }
}
?>

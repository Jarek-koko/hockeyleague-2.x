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

class HockeyViewPlayoff extends JView {

  public  function display($tpl = null) {
      
        $option = JRequest::getCmd('option');
        $mainframe = &JFactory::getApplication();
        $sez = HockeyHelperSelectSeason::SelSez();

        $kolejka_nr = JRequest::getVar('kol', 0, 'post', 'INT');
        $cid = JRequest::getVar('cid', array(0), '', 'array');
        JArrayHelper::toInteger($cid, array(0));
        $task = JRequest::getCmd('task');

        // ================= add ====
        if ($task == 'add') {
            // get model
            $model = &$this->getModel('teams');
            $kl = $model->getSeasonTeamsSelect();
            //get match info
            JTable::addIncludePath(JPATH_COMPONENT . DS . 'tables');
            $row = & JTable::getInstance('match', 'Table');
            $row->load(0);

            $this->assignRef('kolejka_nr', $kolejka_nr = null);
            $this->assignRef('row', $row);
            $this->assignRef('option', $option);
            $this->assignRef('kl', $kl);
            $this->assignRef('sez', $sez);
            $this->addToolbar();
            parent::display($tpl);
        }
        // ============= edit ====
        if ($task == 'edit') {
        
            if (($kolejka_nr == 0) or ($cid == array(0))) {
                $link = 'index.php?option=' . $option . '&view=playoff';
                $type = 'notice';
                $msg = JText::_('HOM_MUST_SELECT_MATCHDAY');
                $mainframe->redirect($link, $msg, $type);
            } else {
                // get model
                $model = &$this->getModel('teams');
                $kl = $model->getSeasonTeamsSelect();

                //get match info
                JTable::addIncludePath(JPATH_COMPONENT . DS . 'tables');
                $row = & JTable::getInstance('match', 'Table');
                $row->load($cid [0]);

                //czy wynik został  zapisany
                if (($row->wynik_1 == null) and ($row->wynik_2 == null )) {
                    $this->assignRef('kolejka_nr', $kolejka_nr);
                    $this->assignRef('row', $row);
                    $this->assignRef('option', $option);
                    $this->assignRef('kl', $kl);
                    $this->assignRef('sez', $sez);
                    $this->addToolbar();
                    parent::display($tpl);
                } else {
                    $link = 'index.php?option=' . $option . '&view=playoff';
                    $type = 'notice';
                    $msg = JText::_('HOM_NOT_ALLOWED');
                    $mainframe->redirect($link, $msg, $type);
                }
            }
        }
    }
    
    protected function addToolbar() {
        $info = HockeyHelperSelectSeason::getNameSez();
        JToolBarHelper::title(JText::_( 'HOCKEY' ).' : '.$info, 'logo.png' );
        JToolBarHelper::save ();
        JToolBarHelper::custom('save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
        JToolBarHelper::cancel ();
    }
}
?>

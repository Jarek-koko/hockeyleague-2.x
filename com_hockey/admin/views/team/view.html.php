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
jimport('joomla.application.component.view');

require_once (JPATH_COMPONENT . DS . 'helpers' . DS . 'position.php');

jimport('joomla.form.form');
require_once JPATH_COMPONENT . '/models/fields/hmedia.php';

class HockeyViewTeam extends JView {

    function display($tpl = null) {
       
        $option = JRequest::getCmd('option');
        $model = $this->getModel('teams');
        $items = $model->getTeam();
        $lists = array();

        if (!JFolder::exists(JPATH_ROOT . DS . 'images' . DS . 'hockey' . DS . 'teams')) {
            $msg = JText::_('HOC_FOLDER_NOT_EXIST');
            $link = 'index.php?option=' . $option . '&view=teams';
            $type = 'error';
            $mainframe = &JFactory::getApplication();
            $mainframe->redirect($link, $msg, $type);
        } else {
            $form = new JForm('form1');
            $field = new JFormFieldHmedia($form);
            $field->setPath('/images/hockey/teams/');
            $string = '<field name="logo" type="hmedia" directory="hockey/teams" required="false" />';
            $xml = simplexml_load_string($string);
            $field->setup($xml, $items->logo);
        }
        $lists ['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $items->published);

        $this->assignRef('field', $field);
        $this->assignRef('lists', $lists);
        $this->assignRef('items', $items);
        $this->assignRef('option', $option);
        $this->_addToolbar();
        parent::display($tpl);
    }

    function _addToolbar() {
        $info = HockeyHelperSelectSeason::getNameSez();
        JToolBarHelper::title(JText::_('HOCKEY') . ' : ' . $info, 'logo.png');
        JToolBarHelper::save ();
        JToolBarHelper::custom('save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
        JToolBarHelper::apply ();
        JToolBarHelper::cancel ();
    }
}
?>

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

class HockeyViewSezon extends JView {

    public function display($tpl = null) {   
      
        $option = JRequest::getCmd('option');
        $model = &$this->getModel('sezon');
        $row = $model->getSezon();

        $pozycja = array();
        //numbers for select
        $items = range(0, 10);
        foreach ($items as $item) {
            $pozycja[] = JHTML::_('select.option', $item);
        }

        $this->assignRef('lists', $lists);
        $this->assignRef('row', $row);
        $this->assignRef('option', $option);
        $this->assignRef('pozycja', $pozycja);
        $this->_addToolbar();
        parent::display($tpl);
  
    }

    protected  function _addToolbar() {
        JToolBarHelper::title(JText::_('HOCKEY'), 'logo.png');
        JToolBarHelper::save();
        JToolBarHelper::cancel ();
    }
}
?>


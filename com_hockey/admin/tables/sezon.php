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

class TableSezon extends JTable {

    var $id = null;
    var $nazwa = null;
    var $p_w = 0;
    var $p_r = 0;
    var $p_p = 0;
    var $p_d_w = 0;
    var $p_d_p = 0;
    var $dogr = null;
    var $p_k_w = 0;
    var $p_k_p = 0;
    var $karne = null;
    var $rok = null;
    var $published = 0;

    public function __construct(&$db) {
        parent::__construct('#__hockey_system', 'id', $db);
    }

    public function check() {

        if (trim($this->nazwa == '')) {
            $this->setError(JText::_('HOC_HOA_NAMESEASON'));
            return false;
        }
        if ((trim($this->p_w == '')) || (trim($this->p_p == '')) || (trim($this->p_p == ''))) {
            $this->setError(JText::_('HOC_HOA_INFO2'));
            return false;
        }
        if ($this->karne == '') {
            $this->setError(JText::_('HOC_HOA_MSG_ERR_PENALTY'));
            return false;
        }
        if ($this->dogr == '') {
            $this->setError(JText::_('HOC_HOA_MSG_ERR_OVERTIME'));
            return false;
        }
        if ($this->rok == '') {
            $this->rok = date('Y');
        }
        return true;
    }
}
?>
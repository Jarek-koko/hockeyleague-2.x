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
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
require_once( JPATH_COMPONENT . DS . 'helpers' . DS . 'season.php' );

class MainController extends JController {

    protected $_sez = null;
    protected $_option = null;
    protected $_type = null;
    protected $_page = null;
    protected $_mainframe = null;
    protected $_id_match = null;

    public function __construct() {
        parent::__construct();
        $this->_mainframe = &JFactory::getApplication();
        $this->_option = JRequest::getCmd('option');
    }

    public function verSez() {
        if ($sez = HockeyHelperSelectSeason::SelSez()) {
            $this->_sez = $sez;
        } else {
            $this->_mainframe->enqueueMessage(JText::_('HOC_MUST_SELECT_SEASON'), 'notice');
            $this->_mainframe->redirect('index.php?option=' . $this->_option . '&view=select');
        }
    }

    /**
     * set $type of match
     * 0 - MATCHDAYS
     * 1 - PLAYOFF
     * 2 - SPARING AND TOURNAMENT
     */
    public function setTypePage() {
        $this->_type = (int) JRequest::getVar('type', 5, '', 'INT');

        switch ($this->_type) {
            case 2:
                $this->_page = 'sparring';
                break;
            case 1:
                $this->_page = 'playoff';
                break;
            case 0:
                $this->_page = 'league';
                break;
            default:
                $this->_mainframe->redirect('index.php?option=' . $this->_option);
                break;
        }
    }

    public function verIdMatch() {
        $this->_id_match = (int) JRequest::getVar('id_match', 0, '', 'INT');

        if (($this->_id_match == 0)) {
            $this->_mainframe->enqueueMessage(JText::_('ERROR ID MATCH'), 'error');
            $this->_mainframe->redirect('index.php?option=' . $this->_option . '&view=' . $this->_page);
        }
    }

    public function cancel() {
        $this->setRedirect('index.php?option=' . $this->_option . '&view=' . $this->_page);
    }

}
?>

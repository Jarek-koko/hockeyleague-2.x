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

/**
 * Script file of Hockey League component
 */
class com_hockeyInstallerScript {

    /**
     * method to install the component
     *
     * @return void
     */
    function install($parent) {
        // $parent is the class calling this method
          echo '<p>' . JText::_('COM_HOCKEY_INSTALL_TEXT') . '</p>';
      //  $parent->getParent()->setRedirectURL('index.php?option=com_hockey');
    }

    /**
     * method to uninstall the component
     *
     * @return void
     */
    function uninstall($parent) {
        // $parent is the class calling this method
        echo '<p>' . JText::_('COM_HOCKEY_UNINSTALL_TEXT') . '</p>';
    }

    /**
     * method to update the component
     *
     * @return void
     */
    function update($parent) {
        // $parent is the class calling this method
        echo '<p>' . JText::_('COM_HOCKEY_UPDATE_TEXT') . '</p>';
    }

    /**
     * method to run before an install/update/uninstall method
     *
     * @return void
     */
    function preflight($type, $parent) {
        $jversion = new JVersion();
        if (version_compare($jversion->getShortVersion(), '1.6', 'lt')) {
            Jerror::raiseWarning(null, 'Cannot install com_hockey in a Joomla release prior to 1.6');
            return false;
        }
    }

    /**
     * method to run after an install/update/uninstall method
     *
     * @return void
     */
    function postflight($type, $parent) {
        echo '<div><b><p>Installation Status :</p></b>';
        if ($direxists[] = JFolder::exists(JPATH_SITE . DS . 'images' . DS . 'hockey')) {
            echo '<p><b><span style="color:green;">FINISHED : - </span></b> Directory created - /images/hockey</p>';
        } else {
            echo '<p><b><span style="color:red;">Note : - </span></b> Directory not created. - /images/hockey </p>';
        }

        if ($direxists[] = JFolder::exists(JPATH_SITE . DS . 'images' . DS . 'hockey' . DS . 'numbers')) {
            echo '<p><b><span style="color:green;">FINISHED : - </span></b> Directory created - /images/hockey/numbers</p>';
        } else {
            echo '<p><b><span style="color:red;">Note : - </span></b> Directory not created - /images/hockey/numbers</p>';
        }

        if ($direxists[] = JFolder::exists(JPATH_SITE . DS . 'images' . DS . 'hockey' . DS . 'players')) {
            echo '<p><b><span style="color:green;">FINISHED : - </span></b> Directory created - /images/hockey/players</p>';
        } else {
            echo '<p><b><span style="color:red;">Note : - </span></b> Directory not created - /images/hockey/players</p>';
        }

        if ($direxists[] = JFolder::exists(JPATH_SITE . DS . 'images' . DS . 'hockey' . DS . 'teams')) {
            echo '<p><b><span style="color:green;">FINISHED : - </span></b> Directory created - /images/hockey/teams</p>';
        } else {
            echo '<p><b><span style="color:red;">Note : - </span></b> Directory not created - /images/hockey/teams</p>';
        }

        echo '<br />';
        if (in_array(false, $direxists)) :
            echo '<code>Please check following directories:
                <ul>
                    <li>/images/hockey</li>
                    <li>/images/hockey/teams</li>
                    <li>/images/hockey/players</li>
                    <li>/images/hockey/numbers</li>
                </ul></code>';
        endif;
        echo '</div>';
    }

}

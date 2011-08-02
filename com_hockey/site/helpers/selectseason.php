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

class JHTMLSelectseason {
  public static function getSelect($lista , $return, $action) {
           
        $html = '<div id="wybor"><form action="'.$action.'" method="post" name="searchForm">
                <fieldset><legend>'.JText::_('HOC_SELECT_SEASON').'</legend>
                <div id="selsez">'.$lista.'<button name="ok" class="colguzik" type="submit">'.JText::_('HOC_GO').'</button></div>
                <input type="hidden" name="return" value="'.$return.'" />'
                .JHtml::_( 'form.token' ).'	
                </fieldset></form></div>';
        return $html;
    }
}
?>

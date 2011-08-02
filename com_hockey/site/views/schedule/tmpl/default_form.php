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
?>
<div class="componentheading"><?php echo JText::_('HOC_SCHEDULEALL_TITLE');  ?> - <?php echo $this->name_season; ?></div>
<div id="wybor">
<form action="<?php echo JRoute::_('index.php?option=com_hockey&task=querypost3');?>" method="post" name="searchForm">
<fieldset><legend><?php echo JText::_('HOC_SELECT_SEASON');?></legend>
<table class="chmatch" border="0" cellpadding="5" cellspacing="5">
    <tbody>
        <tr>
            <th><?php echo JText::_('HOC_SEASON');  ?></th>
            <th><?php echo JText::_('HOC_GAME_TYPE');  ?></th>
            <th><?php if (isset($this->where ))echo JText::_('HOC_HOME_AWAY');  ?></th>
            <th></th>
        </tr>
        <tr>
            <td><?php echo $this->lista; ?></td>
            <td><?php echo $this->tom; ?></td>
            <td><?php if (isset($this->where )) echo $this->where; ?></td>
            <td>
             <input name="ok" value="<?php echo JText::_('HOC_GO');  ?>" class="colguzik" type="submit" />
             <input type="hidden" name="return" value="<?php echo $this->return; ?>" />
             <?php echo JHtml::_( 'form.token' ); ?>
            </td>
        </tr>
    </tbody>
</table>
</fieldset>
</form>
</div>

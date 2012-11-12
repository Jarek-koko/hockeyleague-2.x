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
JHTML::_('behavior.formvalidation');
?>
<script type="text/javascript">
    //<![CDATA[
    Joomla.submitbutton = function(pressbutton) {
        var form = document.adminForm;

        if (pressbutton == 'cancel') {
            submitform( pressbutton );
            return;
        }
        
        document.formvalidator.setHandler('notzero',function(value) {
            return  (value!=0)? true : false;
        });
        if( document.formvalidator.isValid( form ) )
        {
            submitform( pressbutton );
            return;
        }
        else
        {
            alert('<?php echo JText::_('HOC_VALUES_NOT_ACCEPTABLE'); ?>');
            return false;
        }
    }
    //]]>
</script>
<div id="ht">
    <form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate">
        <fieldset class="adminform"><legend><?php echo JText::_('HOC_STATS_PLAYER_INFO'); ?></legend>
            <table class="admintable">
                <tr>
                    <td  class="key"><?php echo JText::_('HOC_PLAYER_NAME'); ?> :</td>
                    <td><input class="text_area required" type="text" name="nazwisko" id="nazwisko" size="50" maxlength="50" value="<?php echo $this->items->nazwisko; ?>" /></td>
                    <td  class="key"><?php echo JText::_('HOC_PLAYER_PHOTO'); ?></td>
                    <td><?php echo $this->field->input; ?></td>
                </tr>
                <tr>
                    <td  class="key"><?php echo JText::_('HOC_PLAYER_FIRST_NAME'); ?> :</td>
                    <td><input class="text_area required" type="text" name="imie" id="imie" size="50" maxlength="50" value="<?php echo $this->items->imie; ?>" /></td>
                    <td rowspan="10" colspan="2" align="center"><td>
                </tr>
                <tr>
                    <td  class="key"><?php echo JText::_('HOC_PLAYER_BIRTHDAY'); ?> :</td>
                    <td>
                         <?php  $tm = ($this->items->data_u == "") ? '0000-00-00' : $this->items->data_u;  ?>
                        <?php echo JHTML::_('calendar', $tm , 'data_u', "data_u", '%Y-%m-%d', array('class' => 'inputbox', 'size' => '10', 'maxlength' => '10')); ?>
                    </td>
                </tr>
                <tr>
                    <td  class="key"><?php echo JText::_('HOC_PLAYER_POSITION'); ?> :</td>
                    <td><?php echo $this->lists ['pozycja'] ?></td>
                </tr>
                <tr>
                    <td  class="key"><?php echo JText::_('HOC_PLAYER_NUMBER'); ?> :</td>
                    <td><input class="text_area validate-numeric" type="text" name="nr" id="nr" size="3" maxlength="3" value="<?php echo $this->items->nr; ?>" /></td>
                </tr>
                <tr>
                    <td  class="key"><?php echo JText::_('HOC_PLAYER_WEIGHT'); ?> :</td>
                    <td><input class="text_area validate-numeric" type="text" name="waga" id="waga" size="3" maxlength="3" value="<?php echo $this->items->waga; ?>" /></td>
                </tr>
                <tr>
                    <td  class="key"><?php echo JText::_('HOC_PLAYER_HEIGHT'); ?> :</td>
                    <td><input class="text_area validate-numeric" type="text" name="wzrost" id="wzrost" size="3" maxlength="3" value="<?php echo $this->items->wzrost; ?>" /></td>
                </tr>
                <tr>
                    <td  class="key"><?php echo JText::_('HOC_PLAYER_TEAM'); ?>  :</td>
                    <td><?php echo $this->lists ['kluby']; ?></td>
                </tr>
                <tr>
                    <td  class="key"><?php echo JText::_('HOC_PLAYER_PRE_TEAM'); ?>:</td>
                    <td><input class="text_area" type="text" name="klubold" id="klubold" size="50" maxlength="50" value="<?php echo $this->items->klubold; ?>" /></td>
                </tr>
                <tr>
                    <td  class="key"><?php echo JText::_('description'); ?> :</td>
                    <td><textarea class="text_area" cols="20" rows="4" name="opis" id="opis" style="width: 500px"><?php echo $this->items->opis; ?></textarea></td>
                </tr>
                <tr>
                    <td  class="key"><?php echo JText::_('HOC_EDIT_DATE'); ?> :</td>
                    <td><?php echo $this->items->review_date; ?></td>
                </tr>
                <tr>
                    <td  class="key"><?php echo JText::_('HOC_ACTIVE_PLAYER'); ?>:</td>
                    <td><?php echo $this->lists ['published']; ?></td>
                </tr>
            </table>
        </fieldset>
        <input type="hidden" name="id" value="<?php echo $this->items->id; ?>" />
        <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
        <input type="hidden" name="view" value="players" />
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>
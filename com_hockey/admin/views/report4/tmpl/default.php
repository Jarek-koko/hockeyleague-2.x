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
    window.addEvent('domready', function() {
        /* autocompler penalty */
        var inputWord = $('note');
        var url2 =  '<?php echo JURI::base(); ?>' + 'index.php?option=<?php echo $this->option; ?>&view=ajax&task=iword&format=raw';
	new Autocompleter.Request.JSON(inputWord, url2 , { 'indicatorClass': 'autocompleter-loading' });
        
        /* ajax replace element select players */
        $('state').addEvent('change', function(event) {
            event.stop();
            var req = new Request({
                method: 'get',
                onRequest: function(){ $('id_player').innerHTML = '<option value="no">Loading ...</option>'; },
                url: '<?php echo JURI::base(); ?>' + 'index.php?option=<?php echo $this->option; ?>&view=ajax&format=raw&state='+ this.getSelected().get("value"),
                onComplete: function(response) { 
                    $('id_player').innerHTML = response;
                }
            }).send();
        });
    });
    
   Joomla.submitbutton = function(pressbutton) {
        var form = document.adminForm;

        if (pressbutton == 'cancel') {
            submitform( pressbutton );
            return;
        }
        
        if (pressbutton == 'remove') {
            submitform( pressbutton );
            return;
        }
        document.formvalidator.setHandler('timematch',function(value) {
            regex=  /^(\d{2})+(\:|\-|\.)+(\d{2})$/;
            return regex.test(value);
        });
        
        document.formvalidator.setHandler('notno',function(value) {
            return  (value!="no")? true : false;
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
<table class="tabshort">
<thead>
    <tr>
        <th><?php echo JText::_('HOS_PERIOD'); ?></th>
        <th><?php echo JText::_('HOS_R_TIME'); ?></th>
        <th><?php echo JText::_('HOC_HOB_TEAMS'); ?></th>
        <th><?php echo JText::_('HOC_PLAYER'); ?></th>
        <th><?php echo JText::_('HOC_PENALTI_TEXT'); ?></th>
        <th><?php echo JText::_('HOC_PENALTI_MIN'); ?></th>
    </tr>
</thead>
<tbody>
<tr>
    <td><select name="period" id="period" class="inputbox">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4"><?php echo JText::_('HOS_OVERTIME'); ?></option>
        </select>
    </td>
    <td><input type="text" name="time" value="" size="4" maxlength="5"  class="required validate-timematch" /></td>
    <td><?php echo JHTML::_('select.genericList', $this->sel, 'state', 'class="inputbox"', 'value', 'text'); ?></td>
    <td>
        <select name="id_player" id="id_player" class="validate-notno">
            <option value="no"><?php echo JText::_('HOS_MUST_SELECT_TEAMS'); ?></option>
        </select>
    </td>
    <td><input type="text" name="note" value="" size="20" maxlength="50"  class="required" id="note" style="text-align: left; width: 250px;"/></td>
    <td><input type="text" name="time_p" value="" size="4" maxlength="4"  class="required validate-numeric"  /> min</td>
</tr>
</tbody>
</table>
<table class="adminlist">
<thead>
    <tr>
        <th>&nbsp;</th>
        <th style="width: 20px;"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" /></th>
        <th style="width: 50px;"><?php echo JText::_('HOS_PERIOD'); ?></th>
        <th style="width: 50px;"><?php echo JText::_('HOS_R_TIME'); ?></th>

        <th style="width: 150px;"><?php echo JText::_('HOC_HOB_TEAMS'); ?></th>
        <th style="width: 150px;"><?php echo JText::_('HOC_PLAYER'); ?></th>
        <th style="width: 250px;"><?php echo JText::_('HOC_PENALTI_TEXT'); ?></th>
        <th style="width: 80px;"><?php echo JText::_('HOC_PENALTI_MIN'); ?></th>
        <th>&nbsp;</th>
    </tr>
</thead>
<tfoot><tr><td colspan="9">  <div id="finfo">
                *<?php echo JText::_('HOC_PENALTI_TEXT'); ?>
                <span>slashing </span>
                <span>butt-ending </span>
                <span>hooking </span>
                <span>diving ... </span>
            </div>
        </td></tr>
</tfoot>
<tbody>
    <?php
    $i = 0;
    foreach ($this->items as $row) {
        $checked = JHTML::_('grid.id', $i, $row->id);
    ?>
        <tr style="text-align:center;">
            <td>&nbsp;</td>
            <td><?php echo $checked; ?></td>
            <td><?php echo ($row->period == 4) ? JText::_('HOS_OVERTIME') : $row->period; ?></td>
            <td><?php echo $row->time; ?></td>
            <td><?php echo ($row->id_team == $this->team['team1']) ? $this->team['druzyna1'] : $this->team['druzyna2']; ?></td>
            <td><?php echo $row->player; ?></td>
            <td><?php echo $row->note; ?></td>
            <td><?php echo $row->time_p; ?></td>
            <td>&nbsp;</td>
        </tr>
    <?php
        $i++;
    }
    ?>
</tbody>
</table>
<?php echo JHtml::_('form.token'); ?>
<input type="hidden" name="type" value="<?php echo $this->type; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="id_match" value="<?php echo $this->id_match ?>" />
<input type="hidden" name="view" value="report4" />
<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
<input type="hidden" name="boxchecked" value="0" />
</form>
</div>

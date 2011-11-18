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
        /* ajax replace element select */
        $('id_team').addEvent('change', function(event) {
            event.stop();
            var req = new Request.JSON({
                method: 'get',
                url: '<?php echo JURI::base(); ?>' + 'index.php?option=<?php echo $this->option; ?>&view=ajax&task=getg&format=raw&id_team='+ this.getSelected().get("value"),
                onComplete: function(response) {            
                    var id_player = $('id_player');
                    id_player.empty();          
                    if (response) {
                        response.each(function(subcat) {
                            var o = new Element('option', {
                                'value':subcat.id,
                                'html':subcat.name
                            }).inject(id_player);                     
                        });
                    } else {
                        var o = new Element('option', {
                            'value': 'no',
                            'html':'<?php echo JText::_('HOS_MUST_SELECT_TEAMS'); ?>'
                        }).inject(id_player);             
                    }
                }
            }).send();
        });
        
    });

   Joomla.submitbutton = function(pressbutton) {
        var form = document.adminForm;

        if( pressbutton == 'cancel' ) {
            submitform( pressbutton );
            return;
        }

        if (pressbutton == 'remove') {
            submitform( pressbutton );
            return;
        }
        
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
    <th><?php echo JText::_('HOC_HOB_TEAMS'); ?></th>
    <th><?php echo JText::_('HOC_GOALIE'); ?></th>
    <th><?php echo JText::_('HOC_SHOT_SAVE'); ?></th>
    <th><?php echo JText::_('HOC_GOALS_AGAINST'); ?></th>
    <th><?php echo JText::_('HOC_TIME_PLAYED'); ?></th>
</tr>
</thead>
<tbody>
<tr>
    <td><?php echo JHTML::_('select.genericList', $this->sel, 'id_team', 'class="inputbox"', 'value', 'text'); ?></td>
    <td>
     <select name="id_player" id="id_player" class="validate-notno">
            <option value="no"><?php echo JText::_('HOS_MUST_SELECT_TEAMS'); ?></option>
     </select>
    </td>
    <td><input type="text" name="save" value="" size="3" maxlength="3" class="required validate-numeric" /></td>
    <td><input type="text" name="goals" value="" size="3" maxlength="3" class="required validate-numeric" /></td>
    <td><input type="text" name="time_p" value="" size="3" maxlength="3" class="required validate-numeric" />&nbsp;min</td>
</tr>
</tbody>
</table>

<table class="adminlist">
<thead>
<tr>
    <th>&nbsp;</th>
    <th style="width: 20px;"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" /></th>
    <th style="width: 150px;"><?php echo JText::_('HOC_GOALIE'); ?></th>
    <th style="width: 150px;"><?php echo JText::_('HOC_SHOT_SAVE'); ?></th>
    <th style="width: 150px;"><?php echo JText::_('HOC_GOALS_AGAINST'); ?></th>
    <th style="width: 150px;"><?php echo JText::_('HOC_TIME_PLAYED'); ?></th>
    <th>&nbsp;</th>
</tr>
</thead>
<tfoot><tr><td colspan="7">&nbsp;</td></tr></tfoot>
<tbody>
<?php
$i = 0;
foreach ($this->items as $row) {
    $checked = JHTML::_('grid.id', $i, $row->id);
?>
<tr style="text-align:center;">
    <td>&nbsp;</td>
    <td><?php echo $checked; ?></td>
    <td><?php echo $row->player; ?></td>
    <td><?php echo $row->save; ?></td>
    <td><?php echo $row->goals; ?></td>
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
<input type="hidden" name="view" value="report5" />
<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
<input type="hidden" name="boxchecked" value="0" />
</form>
</div>
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

$params = &JComponentHelper::getParams($this->option);
$options = array();
for ($i = 1; $i < 10; $i++) {
    $options[] = JHTML::_('select.option', $i, $params->get('round' . $i));
}
?>
<script type="text/javascript">
    //<![CDATA[
 Joomla.submitbutton = function(pressbutton) {
        var form = document.adminForm;

        if (pressbutton == 'cancel') {
            submitform( pressbutton );
            return;
        }
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
<form action="index.php" method="post" name="adminForm" class="form-validate" id="adminForm">
<h1><?php echo JText::_(($this->kolejka_nr == null) ? 'HOA_ADD_PLAYOFF_MATCH' : 'HOA_EDIT_PLAYOFF_MATCH'); ?></h1>
<table class="adminlist">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th style="width: 150px;"><?php echo JText::_('HOA_DATE_MATCHE'); ?></th>
            <th style="width: 150px;"><?php echo JText::_('HOA_NR_ROUND'); ?></th>
            <th style="width: 200px;"><?php echo JText::_('HOA_HOME'); ?></th>
            <th style="width: 200px;"><?php echo JText::_('HOA_VISITORS'); ?></th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tfoot><tr><td colspan="6">&nbsp;</td></tr></tfoot>
    <tbody>
        <tr style="text-align:center;">
            <td>&nbsp;</td>
            <td><?php echo JHTML::_('calendar', $this->row->data , 'data', "data", '%Y-%m-%d', array('class' => 'inputbox required', 'size' => '10', 'maxlength' => '10')); ?></td>
            <td><?php echo JHTML::_('select.genericlist', $options, 'id_kolejka','class="inputbox"', 'value', 'text', $this->kolejka_nr); ?></td>
            <td><?php echo JHTML::_('select.genericList', $this->kl, 'druzyna1', 'class="inputbox"', 'value', 'text', $this->row->druzyna1); ?></td>
            <td><?php echo JHTML::_('select.genericlist', $this->kl, 'druzyna2', 'class="inputbox"', 'value', 'text', $this->row->druzyna2); ?></td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>
<?php echo JHtml::_('form.token'); ?>
<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
<input type="hidden" name="published" value="<?php echo $this->row->published ?>" />
<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
<input type="hidden" name="view" value="playoff" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="id_system" value="<?php echo $this->sez; ?>" />
<input type="hidden" name="type_of_match" value="1" />
</form>
</div>
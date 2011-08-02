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
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
<table class="adminlist">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th style="width: 50px;">ID</th>
            <th style="width: 150px;"><?php echo JText::_('HOA_DATE_MATCHE'); ?></th>
            <th style="width: 150px;"><?php echo JText::_('HOA_NR_MATCHDAYS'); ?></th>
            <th style="width: 200px;"><?php echo JText::_('HOA_HOME'); ?></th>
            <th style="width: 200px;"><?php echo JText::_('HOA_VISITORS'); ?></th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php for ($i = 0; $i < $this->liczba_s; $i++) { ?>
            <tr style="text-align:center;">
                <td>&nbsp;</td>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo JHTML::_('calendar', $this->data , 'data'.$i , "data".$i , '%Y-%m-%d', array('class' => 'inputbox required', 'size' => '10', 'maxlength' => '10')); ?></td>
                <td><input type="text" name="kolejka_nr<?php echo $i; ?>" value="<?php echo $this->kolejka_nr; ?>" size="3" class="required validate-numeric"  /></td>
                <td><?php echo JHTML::_('select.genericList', $this->kl, 'druzyna1' . $i, 'class="inputbox"', 'value', 'text'); ?></td>
                <td><?php echo JHTML::_('select.genericlist', $this->kl, 'druzyna2' . $i, 'class="inputbox" ', 'value', 'text'); ?></td>
                <td>&nbsp;</td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<input type="hidden" name="liczba" value="<?php echo $this->liczba_s; ?>" />
<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
<input type="hidden" name="type_of_match" value="0" />
<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>
</div>
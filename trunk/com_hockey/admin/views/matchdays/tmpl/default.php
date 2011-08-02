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
<div class="newadd">
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
    <fieldset>
    <ul>
        <li>
            <label for="kolejka_nr"><?php echo JText::_('HOA_NR_MATCHDAYS'); ?>  : </label>
            <?php echo $this->lists ['kolejka_nr']; ?>
        </li>
        <li><label for="liczba_s"><?php echo JText::_('HOA_TOTAL_MATCHES'); ?> : </label>
            <?php echo $this->lists ['liczba_s']; ?>
        </li>
        <li><label for="Data"><?php echo JText::_('HOA_MATCH_DAYDATE'); ?> : </label>
            <?php echo JHTML::_('calendar', date('Y-m-d'), 'data', "data", '%Y-%m-%d', array('class' => 'inputbox required', 'size' => '10', 'maxlength' => '10')); ?>
        </li>
    </ul>
    </fieldset>
    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>
</div>
</div>
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
<div id="ht">
    <form action="index.php" method="post" name="adminForm" id="adminForm">
        <div class="selsez">
            <p><b><?php echo JText::_('HOC_SELECTSEASON'); ?></b></p>
            <select name="sez">
             <?php
               foreach($this->sezons as $sezon) {
                  echo '<option value="' . $sezon['id'] . '">' . $sezon['nazwa'] . '</option>';
                }
             ?>
            </select>
        </div>
        <?php echo JHtml::_('form.token'); ?>
        <input type="hidden" name="task" value="save" />
        <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
        <input type="hidden" name="view" value="select" />
    </form>
</div>
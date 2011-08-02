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
$link1 = JRoute::_('index.php?option=com_hockey&view=statsallteams&id=1&format=raw', false);
$link2 = JRoute::_('index.php?option=com_hockey&view=statsallteams&id=2&format=raw', false);
$link3 = JRoute::_('index.php?option=com_hockey&view=statsallteams&id=3&format=raw', false);
$link4 = JRoute::_('index.php?option=com_hockey&view=statsallteams&id=4&format=raw', false);
?>
<div class="componentheading"><?php echo $this->params->get('titlehead') ?></div>
<script type="text/javascript">
    //<![CDATA[
    jQuery.noConflict();
    jQuery(document).ready(function($)
    {
        $("ul.css-tabs").tabs("div.css-panes > div", {effect: 'ajax',
           onBeforeClick: function(event, i) {
		    var pane = this.getPanes("div.panes > div");
			pane.html('<img src="<?php echo  JURI::base(true) ?>/components/com_hockey/assets/loading.gif" />');
	 }
        });
    });
    //]]>
</script>
<?php if ($this->params->get('show_select')) echo $this->select_season; ?>
<div id="steam">
<ul class="css-tabs">
    <li><a href="<?php echo $link1; ?>"><span><?php echo JText::_('HOC_STAT_PLAYERS_R'); ?> </span></a></li>
    <li><a href="<?php echo $link2; ?>"><span><?php echo JText::_('HOC_STAT_PLAYERS_P'); ?> </span></a></li>
    <li><a href="<?php echo $link3; ?>"><span><?php echo JText::_('HOC_STAT_GOALIES_R'); ?> </span></a></li>
    <li><a href="<?php echo $link4; ?>"><span><?php echo JText::_('HOC_STAT_GOALIES_P'); ?> </span></a></li>
</ul>
<div class="css-panes">
    <div style="display:block"></div>
</div>
</div>
<?php
/*
 * @package Joomla 1.7
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @module Hockey League - Standings
 * @copyright Copyright (C) Klich Jarosław
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<script type="text/javascript">
//<![CDATA[
jQuery.noConflict();
jQuery(document).ready(function($)
{
    $("ul.tabs-nav").tabs("div.tabs-panes > div", {effect: 'ajax', onBeforeClick: function(event, i) {
       var pane = this.getPanes("div.tabs-panes > div");
           pane.html('<img src="<?php echo  JURI::base(true) ?>/components/com_hockey/assets/loading.gif" />');
     }
    });
});
//]]>
</script>
<div id="topplayers">
<ul class="tabs-nav">
    <li><a href="<?php echo $link1; ?>"><span><?php echo $title1; ?> </span></a></li>
    <li><a href="<?php echo $link2; ?>"><span><?php echo $title2; ?> </span></a></li>
    <li><a href="<?php echo $link3; ?>"><span><?php echo $title3; ?> </span></a></li>
</ul>
<div class="tabs-panes">
<div style="display:block"></div>
</div>
</div>
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
$path = JURI::base(true) . '/images/hockey/players';

//calculate years of age (input string: YYYY-MM-DD)
function birthday($dage) {
    list($Y, $m, $d) = explode("-", $dage);
    return( date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y );
}
?>
<script type="text/javascript">
    //<![CDATA[
    jQuery.noConflict();
    jQuery(document).ready(function($) {
        $("#tableplayers0,#tableplayers1,#tableplayers2").tablesorter({sortList:[[0,0]], headers:{1:{sorter: false}, 2:{sorter: false} ,6:{sorter: false}}, widgets: ['zebra']});
    }
);
    //]]>
</script>
<div class="componentheading"><?php echo JText::_('HOC_PLAYERS_TITLE'); ?> - <?php echo $this->team_name; ?></div>
<?php
if ($this->players) {
$n = count($this->players);
$tmp_pos = null;

for ($i = 0, $b = 0; $i < $n; $i++) {
$row = &$this->players [$i];
$kow = &$this->players [$i + 1];
$j = $i + 1;
$url = JRoute::_('index.php?option=com_hockey&view=player&id=' . $row->id);
if ($tmp_pos != $row->pozycja) {
?>
<div class="headtab">
    <div>:: <?php echo $this->position[$row->pozycja]; ?> ::</div>
</div>
<table class="tableplayers" id="tableplayers<?php echo $b;$b++; ?>" border="0" cellpadding="0" cellspacing="1">
    <thead>
        <tr>
            <th> # </th>
            <th><?php echo JText::_('HOC_PLAYER_NAME'); ?></th>
            <th><?php echo JText::_('HOC_PLAYER_DATE'); ?></th>
            <th><?php echo JText::_('HOC_PLAYER_HEIGHT'); ?></th>
            <th><?php echo JText::_('HOC_PLAYER_WEIGHT'); ?></th>
            <th><?php echo JText::_('HOC_PLAYER_AGE'); ?></th>
            <th><?php echo JText::_('HOC_PLAYER_OLD_TEAM'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
    }
    ?>
    <tr>
        <td><?php echo $j ?></td>
        <td class="al"><a href="<?php echo $url; ?>" class="tooltip" rel="<?php echo $path . '/' . $row->foto; ?>"><span><?php echo$row->imie . ' ' . $row->nazwisko ?></span></a></td>
        <td><?php echo ($row->data_u === "0000-00-00") ? ' ' : JHTML::_('date', $row->data_u, JText::_('DATE_FORMAT_LC4')); ?></td>
        <td><?php echo $row->wzrost ?></td>
        <td><?php echo $row->waga ?></td>
        <td><?php echo ($row->data_u === "0000-00-00") ? ' ' : birthday($row->data_u) ?></td>
        <td><?php echo $row->klubold ?></td>
    </tr>
    <?php
    if (is_object($kow)) {
        if (($kow->pozycja != $row->pozycja)) {
            echo '</tbody></table>';
        }
    } else {
        echo '</tbody></table>';
    }
    $tmp_pos = $row->pozycja;
}
} else
  echo "<p><b>" . JText::_('HOC_NO_DATA') . "</b></p>";
?>

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
require_once( JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_hockey' . DS . 'helpers' . DS . 'position.php' );
$i = 1;
$show = null;
?>
<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function()
    {
        jQuery(" #tableplayers1, #tableplayers2, #tableplayers3, #tableplayers4").tablesorter({widgets:['zebra']});
    });
    //]]>
</script>
<div class="headtab" style="display:block">
    <div><?php echo $this->title; ?></div>
</div>
<?php if (($this->id == 4) || ($this->id == 3)) : ?>
    <table  class="tableplayers" id="tableplayers<?php echo $this->id ?>" border="0" cellpadding="0" cellspacing="1">
        <thead>
            <tr><th>*</th><th><?php echo JText::_('HOC_STATS_POS') ?></th>
                <th><?php echo JText::_('HOC_PLAYER') ?></th>
                <th><?php echo JText::_('HOC_STATS_MATCH') ?></th>
                <th><?php echo JText::_('HOC_MIN_PLAYED') ?></th>
                <th><?php echo JText::_('HOC_GOALS_AGAINST') ?></th>
                <th><?php echo JText::_('HOC_STATS_SAVE') ?></th>
                <th><?php echo JText::_('HOC_GAA') ?></th>
                <th><?php echo JText::_('HOC_SAVE_PORCENTAGE') ?></th>
                <th><?php echo JText::_('HOC_STATS_SCORED') ?></th>
                <th><?php echo JText::_('HOC_STATS_ASISTS') ?></th>
                <th><?php echo JText::_('HOC_STATS_PENALTY') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($this->lista as $row) :
                $uri = JRoute::_('index.php?option=com_hockey&view=player&id=' . $row->id);
                @$sv = ($row->total_save / ($row->total_goals + $row->total_save));
                @$gaa = ($row->total_goals * 60) / $row->time_match;
                ?>
                <tr><td><?php echo $i ?></td>
                    <td><?php echo HockeyHelperPosition::getPositionShort((int) $row->pozycja) ?></td>
                    <td style="text-align:left; padding-left: 10px;"><a href="<?php echo $uri ?>"><?php echo $row->imie ?> <?php echo $row->nazwisko ?></a></td>
                    <td><?php echo $row->mecze ?></td>
                    <td><?php echo $row->time_match ?></td>
                    <td><?php echo $row->total_goals ?></td>
                    <td><?php echo $row->total_save ?></td>
                    <td><?php echo round($gaa, 2) ?></td>
                    <td><?php echo round($sv, 2) ?></td>
                    <td><?php echo $row->bramki ?></td>
                    <td><?php echo $row->asysty ?></td>
                    <td><?php echo $row->kary ?></td>
                </tr>
                <?php $i++;
            endforeach; ?>
        </tbody></table>
    <div class="leg_p"><?php echo JText::_('HOC_STATS_INFO_G') ?><br /><?php echo JText::_('HOC_STATS_INFO') ?></div>
<?php else : ?>
    <table  class="tableplayers" id="tableplayers<?php echo $this->id ?>" border="0" cellpadding="0" cellspacing="1">
        <thead>
            <tr><th>*</th>
                <th><?php echo JText::_('HOC_STATS_POS') ?></th>
                <th><?php echo JText::_('HOC_PLAYER') ?></th>
                <th><?php echo JText::_('HOC_STATS_MATCH') ?></th>
                <th><?php echo JText::_('HOC_STATS_POINTS') ?></th>
                <th><?php echo JText::_('HOC_STATS_SCORED') ?></th>
                <th><?php echo JText::_('HOC_STATS_ASISTS') ?></th>
                <th><?php echo JText::_('HOC_STATS_PENALTY') ?></th></tr>
        </thead><tbody>
        <?php
        foreach ($this->lista as $row) :
            $uri = JRoute::_('index.php?option=com_hockey&view=player&id=' . $row->id);
            ?>
            <tr><td><?php echo $i ?></td>
                <td><?php echo HockeyHelperPosition::getPositionShort((int) $row->pozycja) ?></td>
                <td style="text-align:left; padding-left: 10px;"><a href="<?php echo $uri ?>"><?php echo $row->imie ?> <?php echo $row->nazwisko ?></a></td>
                <td><?php echo $row->mecze ?></td>
                <td><?php echo $row->punkty ?></td>
                <td><?php echo $row->bramki ?></td>
                <td><?php echo $row->asysty ?></td>
                <td><?php echo $row->kary ?></td>
            </tr>
        <?php $i++;
    endforeach; ?>
    </tbody></table>
    <div class="leg_p"><?php echo JText::_('HOC_STATS_INFO_P') ?><br /><?php echo JText::_('HOC_STATS_INFO') ?></div>
<?php endif ?>

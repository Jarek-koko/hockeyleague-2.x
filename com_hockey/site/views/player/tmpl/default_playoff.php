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
<?php if ($this->player->pozycja != 1): ?>
    <?php if ($this->playoff_stat) : ?>
        <table class="tabplayer">
            <tr><th colspan="6"><?php echo JText::_('HOC_PLAYER_PO') ?></th></tr>
            <tr><th><?php echo JText::_('HOC_SEASON') ?></th>
                <th><?php echo JText::_('HOC_STATS_MATCH') ?></th>
                <th><?php echo JText::_('HOC_STATS_SCORED') ?></th>
                <th><?php echo JText::_('HOC_STATS_ASISTS') ?></th>
                <th><?php echo JText::_('HOC_STATS_POINTS') ?></th>
                <th><?php echo JText::_('HOC_STATS_PENALTY') ?></th>
            </tr>
            <?php foreach ($this->playoff_stat as $row): ?>
                <?php $points = $row->assist + $row->shoot; ?>
                <tr><td><?php echo $row->nazwa ?></td>
                    <td><?php echo $row->meczy ?></td>
                    <td><?php echo $row->shoot ?></td>
                    <td><?php echo $row->assist ?></td>
                    <td><?php echo $points ?></td>
                    <td><?php echo $row->kary ?></td>
                </tr>
            <?php endforeach; ?>
        </table><div class="leg_p"><?php echo JText::_('HOC_STATS_INFO_P') ?></div>
    <?php endif; ?>
<?php endif ?>
<?php if ($this->player->pozycja == 1): ?>
    <?php if ($this->playoff_stat): ?>
        <table class="tabplayer">
            <tr><th colspan="10"><?php echo JText::_('HOC_PLAYER_PO') ?></th></tr>
            <tr><th><?php echo JText::_('HOC_SEASON') ?></th>
                <th><?php echo JText::_('HOC_STATS_MATCH') ?></th>
                <th><?php echo JText::_('HOC_MIN_PLAYED') ?></th>
                <th><?php echo JText::_('HOC_GOALS_AGAINST') ?></th>
                <th><?php echo JText::_('HOC_STATS_SAVE') ?></th>
                <th><?php echo JText::_('HOC_GAA') ?></th>
                <th><?php echo JText::_('HOC_SAVE_PORCENTAGE') ?></th>
                <th><?php echo JText::_('HOC_STATS_SCORED') ?></th>
                <th><?php echo JText::_('HOC_STATS_ASISTS') ?></th>
                <th><?php echo JText::_('HOC_STATS_PENALTY') ?></th>
                <?php
                foreach ($this->playoff_stat as $row):
                    @$sv = ($row->total_save / ($row->total_goals + $row->total_save));
                    @$gaa = ($row->total_goals * 60) / $row->time_match;
                    ?>
                <tr><td><?php echo $row->nazwa ?></td>
                    <td><?php echo $row->meczy ?></td>
                    <td><?php echo $row->time_match ?></td>
                    <td><?php echo $row->total_goals ?></td>
                    <td><?php echo $row->total_save ?></td>
                    <td><?php echo round($gaa, 2) ?></td>
                    <td><?php echo round($sv, 2) ?></td>
                    <td><?php echo $row->shoot ?></td>
                    <td><?php echo $row->assist ?></td>
                    <td><?php echo $row->kary ?></td>
                </tr>
            <?php endforeach; ?>
        </table><div class="leg_p"><?php echo JText::_('HOC_STATS_INFO_G') ?></div>
    <?php endif; ?>
    <?php endif ?>
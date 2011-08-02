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
<script type="text/javascript">
//<![CDATA[
function selectMat(){
var f = document.adminForm;
if(f){
f.elements['nrrrkol'].value = f.elements['id_kolejka'].value;
f.submit();
}
}
//]]>
</script>
<div id="ht">
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" id="adminForm">
<?php echo $this->loadTemplate('select'); ?>
<table class="adminlist">
<thead>
    <tr>
        <th rowspan="2">&nbsp;</th>
        <th style="width: 20px;" rowspan="2"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" /></th>
        <th style="width: 50px;" rowspan="2">ID</th>
        <th style="width: 80px;" rowspan="2"><?php echo JText::_('HOA_DATE_MATCHE'); ?></th>
        <th style="width: 120px;" rowspan="2"><?php echo JText::_('HOA_HOME'); ?></th>
        <th style="width: 90px;" rowspan="2"><?php echo JText::_('HOM_SCORE'); ?></th>
        <th style="width: 120px;" rowspan="2"><?php echo JText::_('HOA_VISITORS'); ?></th>
        <th colspan="7"><?php echo JText::_('HOM_COVERAGE') ?></th>
        <th style="width: 50px;" nowrap="nowrap" rowspan="2"><?php echo JText::_('HOC_PAGE') ?></th>
        <th rowspan="2">&nbsp;</th>
    </tr>
    <tr>
        <th style="width: 25px;">S</th>
        <th style="width: 25px;">T</th>
        <th style="width: 25px;">G</th>
        <th style="width: 25px;">P</th>
        <th style="width: 25px;">GS</th>
        <th style="width: 25px;">R</th>
        <th style="width: 25px;">D</th>
    </tr>
</thead>
<tfoot>
    <tr><td colspan="16">
        <div id="finfo">
            <span> <b>S</b> - <?php echo JText::_('HOM_SCORE'); ?></span>
            <span><b>T</b> - <?php echo JText::_('HOM_TEAMS'); ?></span>
            <span><b>G</b> - <?php echo JText::_('HOM_GOALS'); ?></span>
            <span><b>P</b> - <?php echo JText::_('HOM_PENALT'); ?></span>
            <span><b>GS</b> - <?php echo JText::_('HOM_GOALIE'); ?></span>
            <span><b>R</b> - <?php echo JText::_('HOM_REFEREES'); ?></span>
            <span><b>D</b> - <?php echo JText::_('HOM_DESCRIPTION'); ?></span>
        </div>
        </td>
    </tr>
</tfoot>
<tbody>
    <?php
    $k = 0;
    $i = 0;
    foreach ($this->items as $row) {
        $checked = JHTML::_('grid.id', $i, $row->id);
        $published = JHTML::_('grid.published', $row, $i);
        $link = JRoute::_('index.php?option=' . $this->option . '&view=report1&type=1&id_match=' . $row->id);
        $link1 = JRoute::_('index.php?option=' . $this->option . '&view=report2&type=1&id_match=' . $row->id);
        $link2 = JRoute::_('index.php?option=' . $this->option . '&view=report3&type=1&id_match=' . $row->id);
        $link3 = JRoute::_('index.php?option=' . $this->option . '&view=report4&type=1&id_match=' . $row->id);
        $link4 = JRoute::_('index.php?option=' . $this->option . '&view=report5&type=1&id_match=' . $row->id);
        $link5 = JRoute::_('index.php?option=' . $this->option . '&view=report6&type=1&id_match=' . $row->id);
        $link6 = JRoute::_('index.php?option=' . $this->option . '&view=report7&type=1&id_match=' . $row->id);
        ?>
        <tr style="text-align:center;" class="<?php echo "row$k"; ?>">
            <td>&nbsp; </td>
            <td><?php echo $checked; ?></td>
            <td><?php echo $row->id; ?></td>
            <td><?php echo $row->data; ?></td>
            <td><?php echo $row->druzyna1 ?></td>
            <td><?php echo ($row->wynik_1 == null ? "--" : $row->wynik_1); ?> : <?php echo ($row->wynik_2 == null ? "--" : $row->wynik_2); ?></td>
            <td><?php echo $row->druzyna2; ?></td>
            <td><a href="<?php echo $link; ?>"><img src="<?php echo JURI::root(true); ?>/administrator/components/com_hockey/assets/add.png" alt="edit" /></a></td>
            <td><a href="<?php echo $link1; ?>"><img src="<?php echo JURI::root(true); ?>/administrator/components/com_hockey/assets/add.png" alt="edit" /></a></td>
            <td><a href="<?php echo $link2; ?>"><img src="<?php echo JURI::root(true); ?>/administrator/components/com_hockey/assets/add.png" alt="edit" /></a></td>
            <td><a href="<?php echo $link3; ?>"><img src="<?php echo JURI::root(true); ?>/administrator/components/com_hockey/assets/add.png" alt="edit" /></a></td>
            <td><a href="<?php echo $link4; ?>"><img src="<?php echo JURI::root(true); ?>/administrator/components/com_hockey/assets/add.png" alt="edit" /></a></td>
            <td><a href="<?php echo $link5; ?>"><img src="<?php echo JURI::root(true); ?>/administrator/components/com_hockey/assets/add.png" alt="edit" /></a></td>
            <td><a href="<?php echo $link6; ?>"><img src="<?php echo JURI::root(true); ?>/administrator/components/com_hockey/assets/add.png" alt="edit" /></a></td>
            <td><?php echo $published; ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        $k = 1 - $k;
        $i++;
    }
    ?>
</tbody>
</table>
<?php echo JHtml::_('form.token'); ?>
<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
<input type="hidden" name="kol" value="<?php echo $this->nr_kol; ?>" />
<input type="hidden" name="nrrrkol" value="" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="type_of_match" value="1" />
</form>
</div>
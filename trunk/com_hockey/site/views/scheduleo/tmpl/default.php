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
<div class="componentheading"><?php echo $this->params->get('title_match'); ?></div>
<div class="bb">
<?php
if ($this->rows) {
$n = count ( $this->rows );
$id_kol = null;

for($i = 0; $i < $n; $i ++) {
    $row = &$this->rows [$i];
    $kow = &$this->rows [$i+1];
    if ($id_kol != $row->id_kolejka ) {
?>
<div class="headtab">
<div>:: <?php echo  $this->params->get('name'.$row->id_kolejka)?> ::</div>
</div>
<table>
<thead>
    <tr><th><?php echo JText::_('HOC_DATE');  ?></th>
        <th><?php echo JText::_('HOC_HOME');  ?></th>
        <th>&nbsp;</th>
        <th><?php echo JText::_('HOC_VISITORS');  ?></th>
        <th>- - -</th>
        <th>- - -</th>
    </tr>
</thead>
<tbody>
<?php }  ?>
<tr>
<td><?php echo JHTML::_('date',  $row->data , JText::_('DATE_FORMAT_LC4')) ?></td>
<td><?php echo $row->team1 ;?></td>
<td>
    <?php
    echo ($row->wynik_1 != null ? $row->wynik_1 : '-');
    echo ' : ';
    echo ($row->wynik_2 != null ? $row->wynik_2 : '-');
    echo '<span class="smp">(';
    echo ($row->w1p1 != null ? $row->w1p1 : '-').':'.($row->w2p1 != null ? $row->w2p1 : '-').', '
        .($row->w1p2 != null ? $row->w1p2 : '-').':'.($row->w2p2 != null ? $row->w2p2 : '-').', '
        .($row->w1p3 != null ? $row->w1p3 : '-').':'.($row->w2p3 != null ? $row->w2p3 : '-');
    echo ')</span>';
    ?>
</td>
<td><?php echo $row->team2 ;?></td>
<td>
    <?php
    if ($row->m_karne == "T") echo JText::_('HOC_PENALTY_SHORT');
    elseif ($row->m_dogr == "T") echo JText::_('HOC_OVERTIME_SHORT');
    else echo '--';?>
</td>
<td>
<?php
 $idlink = $this->params->get('idteamlink');
 if    (($row->wynik_1 != null) && ($row->wynik_2  != null) && (($idlink == 0 ) || ($idlink == $row->druzyna1 ) || ($idlink == $row->druzyna2 ))) {
 echo  '<a href="'.JRoute::_('index.php?option=com_hockey&view=report&id='. $row->id ,false ).'">
         <img src="'.JURI::base(true).'/components/com_hockey/assets/plik.png" alt="'.JText::_( 'HOC_RAPORT' ).'" /></a>';
 }
?>
</td>
</tr>
        <?php
        if (is_object($kow)) {
            if (($kow->id_kolejka != $row->id_kolejka)) {
                echo '</tbody></table>';
            }
        } else {
            echo '</tbody></table>';
        }
        $id_kol = $row->id_kolejka;
    }
} else echo JText::_('HOC_NO_DATA');  ?>
</div>

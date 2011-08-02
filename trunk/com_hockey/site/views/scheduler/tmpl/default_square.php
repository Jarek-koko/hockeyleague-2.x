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
jQuery.noConflict();
jQuery(document).ready(function($){
$('.square a').click(function() {
    $('[name=matchday]').val($(this).text());
    $('#form-squer').submit();
});
});
//]]>
</script>
<form action="<?php echo JRoute::_('index.php?option=com_hockey&task=querypost2'); ?>" method="post"  id="form-squer">
<div class="square">
<p><b><?php echo JText::_('HOC_SELECT_MATCHDAY') ?></b></p>
<table class="kol">
<tr>
<?php
$listakol = $this->list;
$c = count($listakol);
$a = $c % 13;
$b = ($a == 0) ? 0 : 13 - $a;
$nr = $b + $c;
$boulid = '';
for ($i = 1; $i <= $nr; $i++) {
    $boulid .= '<td>';
    if (!empty($listakol[$i - 1])) {
        $red = ($listakol[$i - 1] == $this->matchday) ? ' class="red" ' : '';
        $boulid .= '<a href="#" ' . $red . '>' . $listakol[$i - 1] . '</a>';
    } else {
        $boulid .= '--';
    }
    $boulid .= '</td>';
    if (($i % 13 == 0) && ($i != $nr))
        $boulid .= '</tr><tr>';
}
echo $boulid;
?>
</tr>
</table>
</div>
<input type="hidden" name="matchday" value="" />
 <?php echo JHtml::_( 'form.token' ); ?>
<input type="hidden" name="return" value="<?php echo $this->return; ?>" />
</form>
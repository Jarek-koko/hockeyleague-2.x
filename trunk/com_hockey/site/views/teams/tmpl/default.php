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
$pate = JURI::base(true) . '/images/hockey/teams/';
?>
<div class="componentheading"><?php echo JText::_('HOC_TEAMS_TITLE') ?></div>
<?php if ($this->params->get('show_select'))
    echo $this->select_season; ?>
<div id="teamshoc">
<?php if ($this->list) : ?>
<?php foreach ($this->list as $value => $key): ?>
<div class="thp">
<div class="lf1">
    <span><?php echo $key->nazwa_d ?></span>
    <img src="<?php echo $pate . $key->logo ?>" alt="<?php echo $key->nazwa_d ?>"  />
</div>
<div class="lf2">
  <div class="des">
   <p><?php echo $key->description ?></p>
  </div>
</div>
<div class="clr">&nbsp;</div>
</div>
<?php endforeach;  ?>
<?php else : ?>
<p><b><?php echo JText::_('HOC_NO_DATA') ?></b></p>
<?php endif; ?>
</div>
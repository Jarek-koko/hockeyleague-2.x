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
<div class="componentheading"><?php echo $this->htitle; ?></div>
<div id="myFlash">
<object type="application/x-shockwave-flash" data="<?php echo JURI::base(true); ?>/components/com_hockey/views/players_flash/tmpl/players.swf" width="800" height="600">
    <param name="movie" value="<?php echo JURI::base(true); ?>/components/com_hockey/views/players_flash/tmpl/players.swf" />
    <param name="quality" value="high"/>
    <param name=FlashVars value="myVariable=<?php echo $this->idteam; ?>&myUrl=<?php echo JURI::base(true); ?>" />
</object>
</div>




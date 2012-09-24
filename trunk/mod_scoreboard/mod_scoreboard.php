<?php
/*
 * @package Joomla 1.7
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @module Hockey League  - Scoreboar
 * @copyright Copyright (C) Klich Jarosław
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
require_once (dirname(__FILE__) . DS . 'helper.php');

$list = modScoreboardHelper::getList($params);
if (!count($list)) {
    echo "<h1>".JText::_('MOD_SCOREBOARD_BAD_ID')."</h1>";
    return;
}
$document = & JFactory::getDocument ();
$document->addScript(JURI::base(true) . '/components/com_hockey/assets/jquery.js');

$path1 = 'images/hockey/numbers/';
$path2 = 'images/hockey/teams/';
$info = $params->get('info', '');
$title = $params->get('title', 'Raport');
$width = (int) $params->get('width', 800);
$height = (int) $params->get('height', 600);
$popup = (int) $params->get('popup', 1);

$show_countdown = (int) $params->get('show_countdown', 1);
$show_button = (int) $params->get('show_button', 1);

$get_gt = (int) $params->get('get_gt', 0);

 if ($get_gt == 0) {
    $day =      (int) $params->get('day', 01);
    $month =    (int) $params->get('month', 01);
    $year =     (int) $params->get('year', 2012);
    $hour =     (int) $params->get('hour', 01);
    $minute =   (int) $params->get('minute', 01);
    $second =   (int) $params->get('second', 01);
 } else {
    $arraydate = explode("-", $list['date']);
    $arraytime = explode(":", $list['time']);
    $day =      (int) $arraydate[2];
    $month =    (int) $arraydate[1];    
    $year =     (int) $arraydate[0];
    $hour =     (int) $arraytime[0];
    $minute =   (int) $arraytime[1];
    $second =   (int) '00';
 }

$sovertime = $params->get('t_sovertime', 'sovertime');
$shoutouts = $params->get('t_shoutouts', 'shoutouts');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$mstart = $params->get('m_start', 'Match is underway');
$tday = $params->get('t_day', 'Days');
$thour = $params->get('t_hour', 'Hours');
$tminute = $params->get('t_minute', 'Minutes');
$tsecond = $params->get('t_second', 'Seconds');

$params = &JComponentHelper::getParams('com_hockey');
$gnumber = intval($params->get('gnumber', 0));

/// digital numbers helper
if ($gnumber == 1) {
    require_once( JPATH_ROOT . DS . 'components' . DS . 'com_hockey' . DS . 'helpers' . DS . 'gnumbers.php' ); 
    $number1 = HockeyHelperGnumbers::getNumber($list['wynik_1']);
    $number2 = HockeyHelperGnumbers::getNumber($list['wynik_2']);
} else {
    $number1 = $list['wynik_1'];
    $number2 = $list['wynik_2'];
}

require JModuleHelper::getLayoutPath('mod_scoreboard', $params->get('layout', 'default'));

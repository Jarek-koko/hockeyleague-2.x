<?php
/*
 * @package Joomla 1.7
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @module Hockey League - Top players
 * @copyright Copyright (C) Klich Jarosław
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');

$sez = intval($params->get('sez', 0));
$idteam = intval($params->get('idteam', 0));
$title1 = ( $params->get('title1', 'P') );
$title2 = ( $params->get('title2', 'G') );
$title3 = ( $params->get('title3', 'A') );
$id = intval($params->get('type_of_match', 0));
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$document = & JFactory::getDocument ();
$document->addScript(JURI::base(true).'/components/com_hockey/assets/jquery.js');
$document->addScript(JURI::base(true).'/components/com_hockey/assets/jquery.tools.min.js');
$link1 = 'index.php?option=com_hockey&view=modtop&id=1&sez='.$sez.'&ide='.$id.'&idteam='.$idteam.'&format=raw';
$link2 = 'index.php?option=com_hockey&view=modtop&id=2&sez='.$sez.'&ide='.$id.'&idteam='.$idteam.'&format=raw';
$link3 = 'index.php?option=com_hockey&view=modtop&id=3&sez='.$sez.'&ide='.$id.'&idteam='.$idteam.'&format=raw';

require JModuleHelper::getLayoutPath('mod_topplayer', $params->get('layout', 'default'));






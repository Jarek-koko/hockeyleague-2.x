<?php
/*
 * @package Joomla 1.6
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Hockey Team
 * @copyright Copyright (C) Klich Jarosław
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

//ACL
if (!JFactory::getUser()->authorise('core.manage', 'com_hockey')) {
        return JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
}

$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::root(true).'/administrator/components/com_hockey/assets/style.css');
// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');
// get controler name 
$controllerName =   (string) JRequest::getVar('view',"info", 'default', 'string');

JSubMenuHelper::addEntry ( JText::_('INFO'), 'index.php?option=com_hockey',                          ("info"     === $controllerName ));
JSubMenuHelper::addEntry ( JText::_('MATCHES'), 'index.php?option=com_hockey&view=league',           ("league"   === $controllerName ));
JSubMenuHelper::addEntry ( JText::_('PLAYOFF'), 'index.php?option=com_hockey&view=playoff',          ("playoff"  === $controllerName ));
JSubMenuHelper::addEntry ( JText::_('SPARRING'), 'index.php?option=com_hockey&view=sparring',        ("sparring" === $controllerName ));
JSubMenuHelper::addEntry ( JText::_('PLAYERS'), 'index.php?option=com_hockey&view=players',          ("players"  === $controllerName ));
JSubMenuHelper::addEntry ( JText::_('TEAMS'), 'index.php?option=com_hockey&view=teams',              ("teams"    === $controllerName ));
JSubMenuHelper::addEntry ( JText::_('REFEREES'), 'index.php?option=com_hockey&view=referees',        ("referees"  === $controllerName ));
JSubMenuHelper::addEntry ( JText::_('TABLE'), 'index.php?option=com_hockey&view=tabela',             ("tabela"   === $controllerName ));
JSubMenuHelper::addEntry ( JText::_('SEASON'), 'index.php?option=com_hockey&view=sezon',             ("sezon"    === $controllerName ));
JSubMenuHelper::addEntry ( JText::_('SELECTSEASON'), 'index.php?option=com_hockey&amp;view=select',  ("select"   === $controllerName ));


if (file_exists ( JPATH_COMPONENT . DS . 'controllers' . DS . $controllerName . '.php' )) {
	require_once (JPATH_COMPONENT . DS . 'controllers' . DS . $controllerName . '.php');
} else {
	require_once (JPATH_COMPONENT . DS . 'controllers' . DS . 'info.php');
}

$controllerName = 'HockeyController' . ucfirst ( $controllerName );
// Create the controller
$controller = new $controllerName ( );
// Perform the Request task
$controller->execute ( JRequest::getCmd ( 'task' ) );
// Redirect if set by the controller
$controller->redirect ();
?>
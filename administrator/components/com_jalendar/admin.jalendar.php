<?php
/**
* @Copyright Copyright (C) 2010- BMForce
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( JPATH_COMPONENT.DS.'controller.php' );


$classname = 'jalendarController';
$controller = new $classname( );
$controller->execute( JRequest::getVar( 'task' ) );

$controller->redirect();
?>
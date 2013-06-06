<?php
/**
* @Copyright Copyright (C) 2008 - 2010 IceTheme
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
******/

if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );


// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';
// Load the virtuemart main parse code
if( file_exists(dirname(__FILE__).'/../../components/com_virtuemart/virtuemart_parser.php' )) {
	require_once( dirname(__FILE__).'/../../components/com_virtuemart/virtuemart_parser.php' );
} else {
	require_once( dirname(__FILE__).'/../components/com_virtuemart/virtuemart_parser.php' );
}


//Start of routine output correct div to enable ajax update to display correctly

global $VM_LANG, $sess, $mm_action_url;

$_SESSION['vmUseGreyBox']       = $params->get( 'vmEnableGreyBox');
$_SESSION['vmCartDirection']    = $params->get( 'vmCartDirection');
$icevmcart_duration 		 	= $params->get( 'icevmcart_duration', '500');
$icevmcart_transitions 		 	= $params->get( 'icevmcart_transitions', 'bounce:out');
$theme                          = $params->get( 'theme' , '');
modIceVMCartHelp::loadMediaFiles( $params, $module, $theme );
require( modIceVMCartHelp::getLayoutByTheme($module, 'virtuemart', $theme) );
?>
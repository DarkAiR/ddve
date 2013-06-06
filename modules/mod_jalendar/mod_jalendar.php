<?php
/**
* @Copyright Copyright (C) 2010- BMForce
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if (!defined ('_JEXEC')) 
{

	define( '_JEXEC', 1 );
	define( 'JPATH_BASE', dirname(__FILE__).'/../..' );
	define( 'DS', DIRECTORY_SEPARATOR );
	require_once('../../configuration.php' );
	require_once('../../includes/defines.php');
	require_once('../../includes/framework.php');

	$ajaxed=1;
	$mainframe =& JFactory::getApplication('site');
	$mainframe->initialise();
	$language =& JFactory::getLanguage();
	$language->load('mod_jalendar');

	$document = &JFactory::getDocument();
   
	$mid = (int) JRequest::getVar('mid');

	$query = "SELECT params FROM #__modules WHERE id = $mid;";

	$database = JFactory::getDBO();
	$database->setQuery($query);
	$params = $database->loadResult();
	$params = new JParameter ($params);
 
}
 

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( dirname(__FILE__).DS.'helper.php' );

$rooturi=parse_url(JURI::root());
$rooturi=$rooturi['scheme'].'://'.$rooturi['host'].'/';

$curmonth=(int) JRequest::getVar('curmonth',($params->get("default_month")?$params->get("default_month"):date('n')));
$curyear=(int) JRequest::getVar('curyear',($params->get("default_year")?$params->get("default_year"):date('Y')));
 
$dayofmonths=array(31,(!($curyear%400)?29:(!($curyear%100)?28:(!($curyear%4)?29:28)) ), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

if (empty($mid)) $mid=$module->id;

$calen = modJalendar::getCal($curmonth,$curyear,$params,$dayofmonths);
if (file_exists(dirname(__FILE__).DS.'../../administrator/components/com_jalendar/config.php') && $params->get( "all_links" )==1) 
{

	require_once(dirname(__FILE__).DS.'../../administrator/components/com_jalendar/config.php');

	$config=new JalendarConfig();
	if ($config->a_type==0 || $config->a_type==2) $links = modJalendar::DayLink($curmonth,$curyear,$config);
	if ($config->a_type==1 || $config->a_type==2) $a_links = modJalendar::DayLinkC($curmonth,$curyear);
	$mergelinks=array_merge((array) $a_links,(array)$links);
}
$cont = modJalendar::getContent($calen,$params,$curmonth,$curyear,$mergelinks,$mid,$ajaxed,$dayofmonths,$rooturi);

if (!($params->get("CSSlist"))) $css=modJalendar::getCSS($params);

require( JModuleHelper::getLayoutPath( 'mod_jalendar' ) );

?>
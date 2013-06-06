<?php
/**
* @Copyright Copyright (C) 2010- calendarium
* @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
**/
defined( '_JEXEC' ) or die( 'Restricted access' );

$lang=$params->get("language");
$theme=$params->get("color_theme");
$num_week=$params->get("num_week");
$time=$params->get("time");
$time_pos=$params->get("time_pos");
$animation=$params->get("animation");
$compact=$params->get("compact");
require( JModuleHelper::getLayoutPath( 'mod_jscal2_for_joomla' ) );

?>
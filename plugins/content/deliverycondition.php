<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$mainframe->registerEvent( 'onPrepareContent', 'plgContentDeliveryCondition' );

/**
* Plugin that loads module positions within content
*/
function plgContentDeliveryCondition( &$row, &$params, $page=0 )
{
    $pattern = "/\{plugin:deliveryCondition\}/i";
    $icon = 'HelloWorld';
    $row->text = preg_replace($pattern, $icon, $row->text);
}
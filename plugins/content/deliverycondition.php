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

    $db =& JFactory::getDBO();
    $query = 'SELECT * FROM #__delivery_condition WHERE published=1 ORDER BY ordering';
    $db->setQuery($query);
    $items = $db->loadObjectList();
    $str = '';
    foreach ($items as $item)
        $str .= $item['text'].' - '.$item['summ'].'<br/>';
    $row->text = preg_replace($pattern, $str, $row->text);
}
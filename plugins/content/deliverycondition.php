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

    $html = '<div class="delivery">'.
            '<table class="list" cellpadding=0 cellspacing=0>';
    foreach ($items as $item)
    {
        $html .= 
            '<tr>'.
                '<td class="district">'.
                $item->text.
                '</td>'.
                '<td class="price">'.
                $item->summ.
                '</td>'.
            '</tr>';
    }
    $html .= '</table>'.
             '</div>';

    $row->text = preg_replace($pattern, $html, $row->text);
}
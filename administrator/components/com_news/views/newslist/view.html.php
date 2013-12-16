<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class NewsListViewNewsList extends JView
{
    function display($tpl = null)
    {
        global $mainframe;
        global $option;

        JToolBarHelper::title( JText::_( 'News Manager' ), 'generic.png' );
        JToolBarHelper::deleteList();
        JToolBarHelper::editListX();
        JToolBarHelper::addNewX();

        $db                 =& JFactory::getDBO();
        $limit              = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart         = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
        $filter_order       = 'cd.ordering';    //$mainframe->getUserStateFromRequest( $option.'filter_order', 'filter_order', 'cd.ordering', 'cmd' );
        $filter_order_Dir   = 'ASC';            //$mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', '', 'word' );
        $where              = '';

        $orderby = ($filter_order == 'cd.ordering')
            ? ' ORDER BY cd.ordering'
            : ' ORDER BY '. $filter_order .' '. $filter_order_Dir .', cd.ordering';

        // get the total number of records
        jimport('joomla.html.pagination');
        $query = 'SELECT COUNT(*) FROM #__news AS cd '.$where;
        $db->setQuery( $query );
        $total = $db->loadResult();
        $pageNav = new JPagination( $total, $limitstart, $limit );

        // Get data from the model
        $query  = 'SELECT *  FROM #__news AS cd ' . $where . $orderby;
        $db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
        $items = $db->loadObjectList();

        $this->assignRef('items', $items);
        $this->assignRef('pageNav', $pageNav);

        parent::display($tpl);
    }
}
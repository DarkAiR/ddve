<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableNews extends JTable
{
    var $id = null;
    var $title = null;
    var $fulltext = null;
    var $mainimage = null;
    var $date = null;
    var $ordering = null;
    var $published = 0;
    
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function TableNews(&$db)
    {
        parent::__construct('#__news', 'id', $db);
    }
}

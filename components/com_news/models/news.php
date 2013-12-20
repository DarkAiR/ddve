<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );

class NewsModelNews extends JModel
{
    const NEWS_LIMIT = 2;

    var $_data;
    var $_total = null;         // Items total
    var $_pagination = null;    // Pagination object


    function __construct()
    {
        parent::__construct();

        // Get pagination request variables
        $limit = self::NEWS_LIMIT;
        $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
 
        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }

    /**
     * Retrieves the news data
     * @return array Array of objects containing the data from the database
     */
    function getData()
    {
        if (empty($this->_data))
        {
            $query = $this->_buildQuery();
            $this->_data = $this->_getList( $query, $this->getState('limitstart'), $this->getState('limit') );
        }
        return $this->_data;
    }

    function getTotal()
    {
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);       
        }
        return $this->_total;
    }

    function getPagination()
    {
        // Load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
        }
        return $this->_pagination;
    }

    function &_getList( $query, $limitstart=0, $limit=0 )
    {
        $this->_db->setQuery( $query, $limitstart, $limit );
        $result = $this->_db->loadAssocList();
        return $result;
    }

    /**
     * Returns the query
     * @return string The query to be used to retrieve the rows from the database
     */
    function _buildQuery()
    {
        $query = 'SELECT * FROM #__news '.
                 'WHERE published = 1 '.
                 'ORDER BY date DESC ';
        return $query;
    }
}
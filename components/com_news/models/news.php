<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );

class NewsModelNews extends JModel
{
    public function getItems($offset = 0, $limit = 100)
    {
        $db =& JFactory::getDBO();

        $query = 'SELECT * FROM #__news '.
                 'WHERE published = 1 '.
                 'ORDER BY ordering ASC '.
                 'LIMIT '.$offset.','.$limit;
        $db->setQuery( $query );
        $res = $db->loadAssocList();
        return $res;
    }
}
<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );

class VacancyModelVacancy extends JModel
{
    public function getItems($offset = 0, $limit = 100)
    {
        $db =& JFactory::getDBO();

        $query = 'SELECT * FROM #__vacancy '.
                 'LIMIT '.$offset.','.$limit;
        $db->setQuery( $query );
        $res = $db->loadAssocList();
        return $res;
    }
}
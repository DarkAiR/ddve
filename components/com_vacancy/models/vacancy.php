<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );

class VacancyModelVacancy extends JModel
{
    public function getTitle()
    {
        $db =& JFactory::getDBO();

        $query = 'SELECT title FROM #__vacancy';
        $db->setQuery( $query );
        $res = $db->loadResult();
        return $res;
    } 

    public function getRequired()
    {
        $db =& JFactory::getDBO();

        $query = 'SELECT required FROM #__vacancy';
        $db->setQuery( $query );
        $res = $db->loadResult();
        return $res;
    } 

    public function getResponsibility()
    {
        $db =& JFactory::getDBO();

        $query = 'SELECT responsibility FROM #__vacancy';
        $db->setQuery( $query );
        $res = $db->loadResult();
        return $res;
    } 

    public function getConditions()
    {
        $db =& JFactory::getDBO();

        $query = 'SELECT conditions FROM #__vacancy';
        $db->setQuery( $query );
        $res = $db->loadResult();
        return $res;
    } 

    public function getPhone()
    {
        $db =& JFactory::getDBO();

        $query = 'SELECT phone FROM #__vacancy';
        $db->setQuery( $query );
        $res = $db->loadResult();
        return $res;
    } 

    public function getInfo()
    {
        $db =& JFactory::getDBO();

        $query = 'SELECT info FROM #__vacancy';
        $db->setQuery( $query );
        $res = $db->loadResult();
        return $res;
    } 
}
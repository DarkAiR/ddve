<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );

class VacancyModelVacancy extends JModel
{
    public function getTitle()
    {
        return $this->getField('title');
    } 

    public function getRequired()
    {
        return $this->getField('required');
    } 

    public function getResponsibility()
    {
        return $this->getField('responsibility');
    } 

    public function getConditions()
    {
        return $this->getField('conditions');
    } 

    public function getPhone()
    {
        return $this->getField('phone');
    } 

    public function getInfo()
    {
        return $this->getField('info');
    }

    public function getSkills()
    {
        return $this->getField('skills');
    }

    public function getAddress()
    {
        return $this->getField('address');
    }

    private function getField($name)
    {
        $db =& JFactory::getDBO();

        $query = 'SELECT '.$name.' FROM #__vacancy';
        $db->setQuery( $query );
        $res = $db->loadResult();
        return $res;
    }
}
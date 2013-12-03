<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
jimport( 'joomla.application.component.model' );
 
class VacancyViewVacancy extends JView
{
    function display($tpl = null)
    {
        $model =& $this->getModel();
        $this->assignRef( 'title', $model->getTitle() );
        $this->assignRef( 'required', $model->getRequired() );
        $this->assignRef( 'responsibility', $model->getResponsibility() );
        $this->assignRef( 'conditions', $model->getConditions() );
        $this->assignRef( 'info', $model->getInfo() );
        $this->assignRef( 'skills', $model->getSkills() );
        $this->assignRef( 'phone', $model->getPhone() );
        $this->assignRef( 'address', $model->getAddress() );
        parent::display($tpl);
    }
}
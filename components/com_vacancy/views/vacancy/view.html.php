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
        $this->assignRef( 'phone', $model->getPhone() );
        $this->assignRef( 'info', $model->getInfo() );
        parent::display($tpl);
    }
}
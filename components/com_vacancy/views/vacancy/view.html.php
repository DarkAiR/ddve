<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
jimport( 'joomla.application.component.model' );
 
class VacancyViewVacancy extends JView
{
    function display($tpl = null)
    {
        $model =& $this->getModel();
        $items = $model->getItems();
        $this->assignRef( 'items', $items );
        parent::display($tpl);
    }
}
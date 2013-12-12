<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class DeliveryConditionsViewDeliveryCondition extends JView
{
	function display($tpl = null)
	{
		$deliveryCondition =& $this->get('Data');
		$isNew = ($deliveryCondition->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'DeliveryCondition' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('deliverycondition', $deliveryCondition);

		parent::display($tpl);
	}
}
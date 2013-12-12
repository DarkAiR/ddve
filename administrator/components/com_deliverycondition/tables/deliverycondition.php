<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableDeliveryCondition extends JTable
{
	var $id = null;
	var $text = null;
	var $summ = null;
	var $ordering = null;
 	var $published = 0;
 	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableDeliveryCondition(&$db)
	{
		parent::__construct('#__delivery_condition', 'id', $db);
	}
}
<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableVacancy extends JTable
{
	var $id = null;
	var $title = null;
	var $required = null;
	var $responsibility = null;
	var $conditions = null;
	var $phone = null;
	var $address = null;
	var $info = null;
	var $skills = null;
	var $ordering = null;
 	var $published = 0;
 	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableVacancy(&$db)
	{
		parent::__construct('#__vacancy', 'id', $db);
	}
}
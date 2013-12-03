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
	var $info = null;

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
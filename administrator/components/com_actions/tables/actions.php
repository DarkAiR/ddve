<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableActions extends JTable
{
	var $id = null;
	var $title = null;
	var $text = null;
	var $smalltext = null;
	var $rollday = 0;
	var $ordering = null;
 	var $published = 0;
 	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableActions(&$db)
	{
		parent::__construct('#__actions', 'id', $db);
	}
}
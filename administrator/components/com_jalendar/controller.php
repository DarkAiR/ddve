<?php
/**
* @Copyright Copyright (C) 2010- BMForce
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class jalendarController extends JController
{
    function display()
    {
		$task = JRequest::getVar( 'task' );
		$controller = JRequest::getVar( 'controller' );
		if ( empty( $task ) && empty( $controller ) ) 
		{
 			JRequest::setVar( 'view', 'config' );
			JRequest::setVar( 'layout', 'config'  );
		}
        parent::display();
		
    }
	
		  function conj()
    {
		JRequest::setVar( 'view', 'config' );
		JRequest::setVar( 'layout', 'conj'  );
	    parent::display();
    }


	    function add()
    {
		JRequest::setVar( 'view', 'config' );
		JRequest::setVar( 'layout', 'edit'  );
	    parent::display();
    }
	
	    function edit()
    {
		JRequest::setVar( 'view', 'config' );
		JRequest::setVar( 'layout', 'edit'  );
	    parent::display();
    }
	
		function cancel()
	{
		
		$link = 'index.php?option=com_jalendar&view=config&layout=conj&task=conj';
		$this->setRedirect($link, $msg);
	}
	
		function back()
	{
		
		$link = 'index.php?option=com_jalendar';
		$this->setRedirect($link, $msg);
	}
	
			function save()
	{
		$model = $this->getModel('config');

		$model->save($post);
   
		$link = 'index.php?option=com_jalendar&view=config&layout=conj&task=conj';
		$this->setRedirect($link, $msg);
	}
	
			function delete()
	{
		$model = $this->getModel('config');

		$model->delete($post);
   
		$link = 'index.php?option=com_jalendar&view=config&layout=conj&task=conj';
		$this->setRedirect($link, $msg);
	}
	
		function saveconfig()
	{
		$model = $this->getModel('config');

		if ($model->saveconfig($post)) 
		{
			$msg = JText::_( 'Greeting Saved!' );
		} 
		else 
		{
			$msg = JText::_( 'Error Save' );
		}

		$link = 'index.php?option=com_jalendar';
		$this->setRedirect($link, $msg);
	}
	
}
?>
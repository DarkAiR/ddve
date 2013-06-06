<?php  
/**
* @Copyright Copyright (C) 2010- BMForce
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access'); 

JHTML::stylesheet( 'pstyle.css', 'components/com_jalendar/css/' );
global $mainframe;
if (!$this->config->type) echo $this->content;
else 
{
	if (count($this->alist_d)) $this->params->set('show_pagination',0);
	else $this->params->set('show_pagination',2);
	
	if (is_file(JPATH_ROOT.DS.'templates'.DS.($mainframe->getTemplate()).DS.'html'.DS.'com_content'.DS.'frontpage'.DS.'default.php'))
	$template=JPATH_ROOT.DS.'templates'.DS.($mainframe->getTemplate()).DS.'html'.DS.'com_content'.DS.'frontpage'.DS.'default.php';
	else $template=JPATH_ROOT.DS.'components'.DS.'com_content'.DS.'views'.DS.'frontpage'.DS.'tmpl'.DS.'default.php';
	require($template);
	
	if (count($this->alist_d) && count($this->alist))
	{
		echo '<hr size=1 width=100% color=black>';
	}
	if (count($this->alist_d))
	{
		$this->params->set('show_pagination',2);
		if (!count($this->alist))
		$this->total=$this->total_d+$this->total;
		else $this->total=count($this->alist_d);
		$this->alist=$this->alist_d;
		
		$this->params->set('show_page_title', 0);
		require($template);
	}
}

 ?>



<?php 
/**
* @Copyright Copyright (C) 2010- BMForce
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');
if (is_file(JPATH_ROOT.DS.'templates'.DS.($mainframe->getTemplate()).DS.'html'.DS.'com_content'.DS.'frontpage'.DS.'default_item.php'))
$template=JPATH_ROOT.DS.'templates'.DS.($mainframe->getTemplate()).DS.'html'.DS.'com_content'.DS.'frontpage'.DS.'default_item.php';
else $template=JPATH_ROOT.DS.'components'.DS.'com_content'.DS.'views'.DS.'frontpage'.DS.'tmpl'.DS.'default_item.php';
require($template);
?>


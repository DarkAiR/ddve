<?php
/**
* @license		GNU/GPL
*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

class JElementCSSlist extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'CSSlist';
	function fetchElement($name, $value, &$node, $control_name)
	{
	
		$files=scandir('../modules/mod_jalendar/css');

		$options[0] = JHTML::_('select.option', '0', JText::_('No'));
		$num=0;
		for($i = 0; $i < count($files); $i++)
		{
			if ($files[$i]!='.' && $files[$i]!='..' && $files[$i]!='index.html')
			{
				$num++;
				$options[$num] = JHTML::_('select.option', $files[$i], $files[$i]);
			}	
		}
		return "<span id=\"$name\">".JHTML::_('select.genericlist', $options, ''.$control_name.'['.$name.']', 'size="1" style="width:100px;"', 'value', 'text', $value, $control_name.$name ) . "</span>";
	}
}
?>
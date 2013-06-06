<?php
/**
 * Module to display any information stored in Joomla! database
 * 
 * @category   Custom
 * @package    DWAnything
 * @author     Ilya Vikharev {@link http://factory.docwriter.ru}
 * @copyright  2009 DocWriter.Ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version    1.00.0001
 * @link       http://factory.docwriter.ru
 * @since      File available since Release 1.00
 */
 
//--No direct access
defined('_JEXEC') or die('Direct access to this location is not allowed.');

/**
 * Helper class for DWAnything
 */
class ModDWAnythingHelper
{
    /**
     * Returns a list of data rows
     *
     * @param string $query SQL query to get params from database
     */
    public function getItems($query) {
        
        // Initialize variables
        $result = null;
        
        // Get a reference to the database
        $db = &JFactory::getDBO();
 
        // Get a list of items
        $db->setQuery($query);
        $result = ($result = $db->loadObjectList()) ? $result : array();
 
        return $result;
    } //end getItems
    
    /**
     * Replace template fields with actual values.
     * 
     * @param string $template template source text
     * @param object $row data object
     * 
     * @return string Populated template
     */
    public function parseTemplate ($template, &$row) {
        
        $result = '';
        
        $result = $template;
        
        $vars = get_object_vars($row);
        
        foreach ($vars as $curKey => $curValue) {
            $result = str_replace('{' . $curKey . '}', $curValue, $result);
        }
        
        return $result;        
    }
 
} //end ModDWAnythingHelper
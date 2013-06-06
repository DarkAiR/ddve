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

$template = $params->get('template');

echo $params->get('header');

foreach ($items as $curRow) {
    echo ModDWAnythingHelper::parseTemplate($template, $curRow);
}

echo $params->get('footer');

?>

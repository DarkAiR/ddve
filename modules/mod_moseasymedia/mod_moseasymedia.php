<?php
/**
 ** @version 2.0.1
 * @package moseasymedia
 * @copyright Copyright &copy; 2008, Brilaps LLC
 * @author Ozgur Cem Sen
 * @email code@brilaps.com
 * @link http://brilaps.com || http://wiki.brilaps.com
 * @license http://www.opensource.org/licenses/gpl-license.php GNU/GPL v.2 .
 * moseasymedia  special build for Joomla 1.5
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @global string $mosConfig_absolute_path Absolute path to Mambo/Joomla installation
 */

global $mosConfig_live_site;
global $MOSEASYMEDIA_BASE_URL;
$MOSEASYMEDIA_BASE_URL = JURI::base()."plugins"."/content/moseasymedia/";

global $mosConfig_absolute_path;
global $MOSEASYMEDIA_ABSOLUTE_PATH;
$MOSEASYMEDIA_ABSOLUTE_PATH = JPATH_PLUGINS."/content/moseasymedia/";


/**
 * @global string Regular Expression to find the mambot in the content. This is relatively simple
 */
global $DEFAULT_MOSEASYMEDIA_FIND_REGEXP;
$DEFAULT_MOSEASYMEDIA_FIND_REGEXP = "/\{moseasymedia\s*(.*?)\}/i";

/**
 * @global string Regular Expression to parse the atributes of the mambot. i.e. media=blah.mpg height=100 width=120
 */
global $DEFAULT_MOSEASYMEDIA_PARSE_ATTRIB_REGEXP;
$DEFAULT_MOSEASYMEDIA_PARSE_ATTRIB_REGEXP = "([\s](\w+)[=]+([^\s]+))";

/**
 * @global string Regular Expression to parse {moseasymedia} attribs
 */
global $DEFAULT_MOSEASYMEDIA_PARSE_REGEXP;
$DEFAULT_MOSEASYMEDIA_PARSE_REGEXP = "/\{(moseasymedia)".$DEFAULT_MOSEASYMEDIA_PARSE_ATTRIB_REGEXP."(.*)\}/i";


/**
 * Include the mambot handler file
 */
require_once($MOSEASYMEDIA_ABSOLUTE_PATH. '/moseasymedia.inc.php');
require_once($MOSEASYMEDIA_ABSOLUTE_PATH. '/moseasymediaParams.php');


//this text will be processed to render the media embedding.
$text = $params->get( 'moseasymedia', '' );
if ($text != '')
{
	if (file_exists(JPATH_PLUGINS.'/content/moseasymedia/moseasymedia.inc.php')) {

		/**
		 * Include the mambot handler file
		 */
		require_once(JPATH_PLUGINS.'/content/moseasymedia/moseasymedia.inc.php');

		/**
		 * load the parms.
		 */
		$mambot =& JPluginHelper::getPlugin('content', 'moseasymedia');
		if ($mambot != null) {
		    $botParams = new JParameter( $mambot->params );
		    //@@TODO: Check this again.
		    if ($botParams !== null) {
		        //read the parms. the media.class will deal with those..
		        				
	            if ( $botParams->get( 'enabled', 1 ) == 1) {
	                $moseasymediaparams = new moseasymediaParams();
	                $moseasymediaparams->setParams($botParams->_registry['_default']['data']);					
                    /**
					 * easy easy easy...Don't you love reusability... ;)
					 */
					echo moseasymediaBot::render_moseasymedia($text, $moseasymediaparams);
	            }
		    }
		}
	}
	else {
		echo "moseasymedia mambot is required. Please download from <a href='http://www.brilaps.com'>http://www.brilaps.com</a>";
	}
}
else {
	echo "Please make sure that the Parameter -moseasymedia string- of moseasymedia Module is set properly. You may check <a href='http://www.brilaps.com'>http://www.brilaps.com</a> for help.";
}
?>

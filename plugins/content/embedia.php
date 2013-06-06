<?php
/**
 * @version 3.0.1
 * @package embedia (formerly mosEasyMedia)
 * @copyright Copyright &copy; 2009, Brilaps LLC
 * @author Ozgur Cem Sen
 * @email code@brilaps.com
 * @link http://brilaps.com || http://wiki.brilaps.com
 * @license http://www.opensource.org/licenses/gpl-license.php GNU/GPL v.2 .
 * embedia special build for Joomla 1.5
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

$mainframe->registerEvent('onPrepareContent', 'plgEmbedia');

function plgEmbedia( &$article, &$params, $limitstart )
{	
	$mambot = JPluginHelper::getPlugin('content', 'embedia');
	if ($mambot != null) 
	{
		$botParams = new JParameter( $mambot->params );
		//@@TODO: Check this again.
		if ($botParams !== null) 
		{
			//read the parms. the media.class will deal with those..
			if ( !$botParams->get( 'enabled', 1 ) ) 
			{
				return true;
			}	
		
			/**
			 * Include the mambot handler file
			 */
			require_once(dirname(__FILE__) . '/embedia/includes/mosEmbediaParameters.class.php');
			require_once(dirname(__FILE__) . '/embedia/includes/embediaParams.class.php');
			require_once(dirname(__FILE__) . '/embedia/embediaBot.class.php');

			$rawParams = $mambot->params;		
			if (empty($rawParams))
			{
				require_once(dirname(__FILE__) . '/embedia/includes/default.params.php');
				$rawParams = DefaultParams::$params;
			}
			$botparams = new mosEmbediaParameters($rawParams);

			//read the parms. the media.class will deal with those..
			$embediaParams = new embediaParams();
			$embediaParams->setParams($botparams->getParams());

			// some funky joomla stuff here!
			embediaJsCssLoader::getInstance()->addJs(JURI::base() . '/plugins/content/embedia/includes/js/embedia.yui.js');
			embediaJsCssLoader::getInstance()->addJs(JURI::base() . '/plugins/content/embedia/includes/js/embedia.js');
			embediaJsCssLoader::getInstance()->addCss(JURI::base() . '/plugins/content/embedia/includes/js/embedia.yui.css');			
			embediaJsCssLoader::getInstance()->addCss(JURI::base() . '/plugins/content/embedia/includes/js/embedia.css');
			embediaJsCssLoader::getInstance()->setLoaded(JURI::base() . '/plugins/content/embedia/includes/js/embedia.yui.js');
			embediaJsCssLoader::getInstance()->setLoaded(JURI::base() . '/plugins/content/embedia/includes/js/embedia.js');
			embediaJsCssLoader::getInstance()->setLoaded(JURI::base() . '/plugins/content/embedia/includes/js/embedia.yui.css');			
			embediaJsCssLoader::getInstance()->setLoaded(JURI::base() . '/plugins/content/embedia/includes/js/embedia.css');
			JHTML::script('embedia.yui.js', 'plugins/content/embedia/includes/js/', false);
			JHTML::script('embedia.js', 'plugins/content/embedia/includes/js/', false);
			JHTML::stylesheet('embedia.yui.css', 'plugins/content/embedia/includes/css/');
			JHTML::stylesheet('embedia.css', 'plugins/content/embedia/includes/css/');
			
			$article->text = embediaBot::render(JURI::base() . '/plugins/content/embedia', $article->text, $embediaParams);	
		}
	}
}

<?php
/**
 * @version 3.0.1
 * @package embedia (formerly mosEasyMedia)
 * @copyright Copyright &copy; 2009, Brilaps LLC
 * @author Ozgur Cem Sen
 * @email code@brilaps.com
 * @link http://brilaps.com || http://wiki.brilaps.com
 * @license http://www.opensource.org/licenses/gpl-license.php GNU/GPL v.2 .
 */

require_once (dirname(__FILE__) . '/embedia.autoloaders.inc.php');

// function pr($foo)
// {
// 	print_r('<pre>');
// 	print_r(var_export($foo, true));
// 	print_r('</pre>');
// }


/**
 * <p>embediaBot class handles the parsing the mambot out of the content and embedding the HTMLized output back in the content.</p>
 * <p>HTMLization takes place in embediaMedia class.</p>
 * @see embediaMedia::embediaMedia()
 */
class embediaBot
{

	/**
	 * This is where it all starts, where it all ends
	 * 
	 * @param string $embediaBaseUrl
	 * @param string $text
	 * @param object $embediaParams
	 * @return   rendered media embed code
	 */
	public static function render( $embediaBaseUrl, $text, $embediaParams )
	{
		$ret = preg_replace_callback($embediaParams->get('embedia_moseasymedia', 'yes') === 'yes' ? DEFAULT_EMBEDIA_MOSEASYMEDIA_FIND_REGEXP : DEFAULT_EMBEDIA_FIND_REGEXP, 
									array(new embediaBot($embediaBaseUrl, $embediaParams), 'process'), 
									$text);
		return embediaJsCssLoader::getInstance()->insertJsFiles().embediaJsCssLoader::getInstance()->insertCssFiles().$ret; 
	}

	/**
	 *
	 * @var object embediaParams
	 */
	private $embediaParams;

	/**
	 * Constructor
	 * only embediaBot::render can instantiate this object.
	 *
	 * @param object $embediaParams
	 * @return embediaBot
	 */
	private function __construct( $embediaBaseUrl, $embediaParams )
	{
		$this->embediaParams 	= $embediaParams;
		$this->embediaBaseUrl 	= $embediaBaseUrl;	 
	}

	/**
	 * Processes each matched {embedia|moseasymedia media=..... } as a callback to preg_replace_callback in embediaBot::render
	 *
	 * @param $matched
	 * @return String
	 */
	private function process( $matched ) 
	{
		$embedCode = '';
		if (count($matched) == 3)
		{
			$braced = trim($matched[2]);
			if (!empty($braced))
			{
				preg_match_all(DEFAULT_EMBEDIA_PARSE_ATTRIB_REGEXP, $braced, $matchedAttribs, PREG_PATTERN_ORDER);

				$matchedAttribCount = count($matchedAttribs[1]);
				if ($matchedAttribCount > 0)
				{
					$attributes = array();
					for ($i = 0; $i < $matchedAttribCount; $i++)
					{
						$key 	= strtolower($matchedAttribs[1][$i]);
						$value 	= html_entity_decode(strip_tags(trim(trim($matchedAttribs[2][$i]), "\x22\x27")));
						$attributes[$key] = $value;
					}

					// make sure the mandatory params exits
					if (count(array_intersect(array_keys($attributes), embediaVars::$MANDATORY_ATTRIBUTES)) !== embediaVars::$MANDATORY_ATTRIBUTES_COUNT)
					{
						return $matched[0] .  MISSING_PIECES;
					}

					// make sure the mandatory params exits
					if (count(array_intersect(array_keys($attributes), embediaVars::$VALID_OVERRIDE_ATTRIBUTES)) !== count(array_keys($attributes)))
					{
						return $matched[0] .  INVALID_ATTRIBUTE;
					}
					
					$attributes['embediaBaseUrl'] = $this->embediaBaseUrl;
					return $this->generateEmbedCode($attributes);
				}
				else
				{
					return $matched[0] . INVALID_FORMAT;
				}
			}
			else
			{
				return $matched[0] . INVALID_FORMAT;
			}
		}
		else
		{
			return IMPOSSIBLE_ERROR;
		}

		return $matched[0] . ' ' . $embedCode;
	}


	/**
	 * Generates embed code
	 *
	 * @param array $attributes
	 * @param object $embediaParams
	 * @return string
	 */
	private function generateEmbedCode( $attributes )
	{
		$playerName = $this->determinePlayer($attributes);
		$decorator 	= new embediaDecorator($playerName, $attributes, $this->embediaParams);
		
		return $decorator->getEmbedCode();
	}


	/**
	 * Detemines which player to use to HTMLize embeddation (what the heck is that !) .
	 *
	 * @param array $attributes params for embedia
	 * @return string the player to handle the HTMLization
	 */
	private function determinePlayer( &$attributes )
	{
		$filesplit = explode('.', $attributes['media']);
		$filetype = $filesplit[count($filesplit) - 1];

		//statement above may end up with a filetype com/v/BvzlZuWrJNw for video sharing websites.
		//probably the easiest check would be a / check.
		if (strpos($filetype, '/') == true)
		{
			$filetype = '';
		}

		//file type should suffice to determine the media type,
		//but not necessarily for the youtube, google, myspace videos
		//on top of all that, for example; we may want to play MPEG files in RealPlayer.
		foreach (embediaVars::$SUPPORTED_MEDIA_PLAYERS as $player)
		{
			if ($filetype != '')
			{
				$extensionParam = 'embedia_Extensions'.$player;
				if( eregi($filetype, $this->embediaParams->get($extensionParam)) != false )
				{
					return $player;
				}
			}
			else
			{
				$param = 'embedia_MediaSharingWebsitesUsing'.$player;
				$sites = trim($this->embediaParams->get($param, ''));
				if (!empty($sites))
				{
					$mediaSharingWebsitesUsingPlugin = explode(',', $sites);
					foreach ($mediaSharingWebsitesUsingPlugin as $site)
					{
						if (stripos($attributes['media'], trim($site)) !== false)
						{
							if ($site == 'youtube.com') 
							{
								$attributes['media'] = str_replace(array('?', '='), '/', $attributes['media']);
							}
							return $player;
						}
					}
				}
			}
		}
		//oh well! worst come to worst, try flash
		return embediaVars::$DEFAULT_PLAYER;
	}
}

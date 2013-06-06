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

class embediaDecorator
{

	/**
	 * Player name
	 *
	 * @var String
	 */
	private $playerName = "";

	/**
	 * Params
	 *
	 * @var Object
	 */
	private $embediaParams = "";


	/**
	 * Params
	 *
	 * @var array
	 */
	private $attributes = "";

	/**
	 * Unique ID for the player to be set in session - for popup security
	 *
	 * @var string
	 */
	private $uniqueID = "";

	/**
	 * Unique div ID for div encapsulating the player
	 *
	 * @var string
	 */
	private $div = "";


	/**
	 * Output string
	 *
	 * @var String
	 */
	private $embedString = "";


	/**
	 * Constructor for base embed class. All other players' classes are derived from this
	 *
	 * @param String $playerName
	 * @param String $mediaPath
	 * @param String $embediaParams
	 * @return embediaDecorator
	 */
	public function __construct( $playerName, $attributes, $embediaParams )
	{
		$this->playerName = $playerName;

		$this->mediaPath =  $attributes['media'];
		$this->embediaParams = $embediaParams;
		$this->attributes = $attributes;

		$this->uniqueID = 'embedia'.$this->playerName.rand();
		$this->div = 'embedia'.$this->playerName.$this->uniqueID;
	}

	/**
	 * Get the embediaPlayerBase for the given file
	 * 
	 * @return mixed
	 */
	private function getPlayer( )
	{
		$playerHandlerFileName = 'embedia' . $this->playerName . '.php';
		$file = dirname(__FILE__) . '/players/' . $playerHandlerFileName;
		if (file_exists($file))
		{
			// @TODO autoloaders sholud've picked this up !
			require_once($file);
			$playerHandlerClass = 'embedia'.$this->playerName;
			if (class_exists($playerHandlerClass, false))
			{
				return new $playerHandlerClass($this);
			}
		}
		else
		{
			return INVALID_PLAYER_HANDLER;
		}
	}

	/**
	 * Finally generate the actual media embed code
	 *
	 * @return string
	 */
	public function getEmbedCode()
	{
		$playerImpl = $this->getPlayer();
		if (($playerImpl !== INVALID_PLAYER_HANDLER) && is_a($playerImpl, 'embediaPlayerBase'))
		{
			embediaJsCssLoader::getInstance()->addJs($this->getOverrideAttribute('embediaBaseUrl') . '/includes/js/embedia.yui.js');
			embediaJsCssLoader::getInstance()->addJs($this->getOverrideAttribute('embediaBaseUrl') . '/includes/js/embedia.js');
			embediaJsCssLoader::getInstance()->addCss($this->getOverrideAttribute('embediaBaseUrl') . '/includes/css/embedia.yui.css');
			embediaJsCssLoader::getInstance()->addCss($this->getOverrideAttribute('embediaBaseUrl') . '/includes/css/embedia.css');
			
			$header = $this->getHeader();
			$footer = $this->getFooter();
						
			$withJs = $this->embediaParams->get("embedia_UseJavascript$this->playerName");
			$popupWindow = $this->getAttribute('embedia_Popup_', 'popup', '', 'none');

			$embedCode = $playerImpl->getEmbedCode();
			//Check to see if we're using object embedding or javascript
			if (!empty($withJs) || ($popupWindow !== 'none'))
			{
				$slashed = addslashes($header . $embedCode . $footer);
				$embedCode =  <<<EMBEDIA
				<script type="text/javascript"> 
					// <![CDATA[ 
						embedia.addMedia("$this->div", "$slashed");
					// ]]>
				</script>
EMBEDIA;
                if ($popupWindow !== 'none')
                {
                    $embedCode .=  <<<EMBEDIA
        				<script type="text/javascript"> 
        					// <![CDATA[ 
        						embedia.setPopupStyle("$this->div", "$popupWindow");
        					// ]]>
        				</script>
EMBEDIA;
                    return $header . $embedCode . $this->popupCode($embedCode) . $footer;
                }
                
			}
            return $header . $embedCode . $footer;
		}
		else
		{
			return $playerImpl;
		}
	}

	public function getHeader( )
	{
		embediaJsCssLoader::getInstance()->addCss($this->getOverrideAttribute('embediaBaseUrl') . '/includes/css/'.$this->embediaParams->get("embedia_CSS$this->playerName", "embedia$this->playerName.css")
		, $this->embediaParams->get("embedia_UseJavascript$this->playerName", '1'));
		$embedString = '<!-- embedia generated embed code, by Brilaps, (c) 2009-->' ;
		$embedString .= '<div class="embedia' . $this->playerName .'" id="' . $this->div . '">';
		return $embedString;
	}

	public function getFooter( )
	{
		$embedString = '</div>';
		$embedString .= '<noscript><div class="embedia-noscript">'.$this->embediaParams->get('noscript', 'Please turn on javascript to view the media.').'</div></noscript>';
		$embedString .= '<!-- embedia -->' ;
		return $embedString;
	}

	public function getThumbnail( )
	{
		$mediathumbnail = $this->getAttribute('embedia_Popup_', 'popupmediathumbnail', '', 'none'); 
		if ($mediathumbnail !== 'none')
		{
			$mediathumbnail = '<img src="' . $mediathumbnail . '" alt="click on the link below to play the media" title="click on the link below to play the media"/><br/>';
		}
		else
		{
			$mediathumbnail = '';
		}

		return $mediathumbnail;
	}

	public function popupCode ( $embedCode )
	{
		$popupWindow = $this->getAttribute('embedia_Popup_', 'popup', '', 'none');

		switch ($popupWindow)
		{
			case 'window': 
			{
				$pop = '<p><a title="click on the link below to play the media" class="moseasmedia-popup-link" rel="' . $this->div . '" href="#' . $this->uniqueID . '">' . $this->getThumbnail().$this->getAttribute('embedia_Popup_', 'popuplinktext').'</a></p>';
	
	            $popupWindowParams = <<<EMBEDIAPOPUPWINDOWPARAMS
	toolbar={$this->getAttribute("embedia_Popup_", "popuptoolbar")},location={$this->getAttribute("embedia_Popup_", "popuplocation")},scrollbars={$this->getAttribute("embedia_Popup_", "popupscrollbars")},menubar={$this->getAttribute("embedia_Popup_", "popupmenubar")},width={$this->getAttribute("embedia_Popup_", "popupwidth")},height={$this->getAttribute("embedia_Popup_", "popupheight")}
EMBEDIAPOPUPWINDOWPARAMS;
	
	            $popupWindowParams = addslashes($popupWindowParams);
				$pop .=  <<<EMBEDIAPOPUPWINDOW
				<script type="text/javascript"> 
					// <![CDATA[ 
						embedia.addMediaPopupWindowParams("$this->div", "$popupWindowParams");     
					// ]]>
					</script> 
EMBEDIAPOPUPWINDOW;
				break;
			};
			case 'overlay':
			{
				embediaJsCssLoader::getInstance()->addCss($this->getOverrideAttribute('embediaBaseUrl') . '/includes/css/embedia.css', $this->embediaParams->get("embedia_UseJavascript$this->playerName", '1'));
				
				$pop = '<p><a title="click on the link below to play the media" class="moseasmedia-popup-link" rel="' . $this->div . '" href="#' . $this->uniqueID . '">' . $this->getThumbnail().$this->embediaParams->get('embedia_Popup_popuplinktext') . '</a></p>';

	            $popupOverlayParams = <<<EMBEDIAOVERLAYPARAMS
	            { width: '{$this->getAttribute("embedia_Popup_", "popupwidth")}',
				  height: '{$this->getAttribute("embedia_Popup_", "popupheight")}'
				}
EMBEDIAOVERLAYPARAMS;

				$pop .=  <<<EMBEDIAPOPUPOVERLAY
				<script type="text/javascript"> 
					// <![CDATA[ 
						embedia.addMediaPopupOverlayParams("$this->div", $popupOverlayParams);     
					// ]]>
				</script>
EMBEDIAPOPUPOVERLAY;
				
				break;	
			} 
			default:
			{
				$pop = '';
				break;
			}
		}
		
		return $pop;
	}

	public function getAttribute( $prefix, $attrib, $suffix = '', $default = '' )
	{
		return isset($this->attributes[$attrib]) ? $this->attributes[$attrib] : $this->embediaParams->get(strtolower($prefix.$attrib.$suffix), $default);
	}

	public function getOverrideAttribute( $attrib, $default = '' )
	{
		return isset($this->attributes[$attrib]) ? $this->attributes[$attrib] : $this->embediaParams->get(strtolower($attrib.$this->playerName), $default);
	}

	public function getAttributes() {return $this->attributes;}

	public function getEmbediaParams() {return $this->embediaParams;}

	public function getPlayerName() {return $this->playerName;}

	public function getUniqueID() {return $this->uniqueID;}


}

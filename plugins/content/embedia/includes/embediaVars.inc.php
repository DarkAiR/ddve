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


class embediaVars 
{
	/**
	 * Those attributes can be overridden in the actual player context. The player implementation will determine the ones to use
	 *
	 * @var array
	 */
	public static $VALID_OVERRIDE_ATTRIBUTES = array('media',
													'width', 'height', 'displayheight',
													'autostart', 'autoplay', 'play', 'autoload',
													'loop', 'playcount', 'repeat', 'repeat_playlist', 'radio_mode',
													'autosize', 'overstretch', 'stretchtofit',
													'player',
													'logo', 'previewimage', 'previewmessage', 'image', 'title', 'link',
													'volume', 'cache', 'scale', 'kioskmode',
													'controls', 'mode', 'largecontrols',
													'custommode', 'wmode', 'bgcolor', 'shuffle', 'singlefile',
													'popup', 'popupwidth', 'popupheight', 'popuptoolbar', 'popupmenubar', 'popupscrollbars', 'popupmediathumbnail'
													);


	/**
	 * doh! if no media, no embed anyways. {embedia media= ....} must exist
	 *
	 * @var array
	 */
	public static $MANDATORY_ATTRIBUTES = array('media');
	public static $MANDATORY_ATTRIBUTES_COUNT = 1;
	
	
	
	/**
	 * embedia can embed media types that can be played by the following players
	 *
	 * @var array
	 */
	public static $SUPPORTED_MEDIA_PLAYERS = array(
											    "WindowsMediaPlayerVideo",
											    "WindowsMediaPlayerAudio",
											    "Flash",
												//"Shockwave",
											    "Quicktime",
											    "RealPlayer",
											    "DivX",
											    //"JWFLVPlayer",
											    "JWMediaPlayer",
											    "JWMP3Player",
											    "XSPFPlayer"
											    );
    public static $DEFAULT_PLAYER = 'Flash';

}

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

class embediaXSPFPlayer extends embediaPlayerBase 
{
	/**
	 * @see embediaPlayerBase::setupAttributes
	 * @return void :)
	 */
	protected function setupAttributes( )
	{
		if ($this->playerDecorator->getOverrideAttribute('embedia_mode') == 'extended')
		{
			$src = $this->playerDecorator->getOverrideAttribute('embediaBaseUrl') . '/includes/players/xspf_player.swf';
		}
		else
		{
			$src = $this->playerDecorator->getOverrideAttribute('embediaBaseUrl') . '/includes/players/xspf_player_slim.swf';
		}

		//the following arrays will serve as attributes to be populated by the $this->embediaParams
		$this->objectAttributes = $this->generateAttributeValuesArray(array('id', 'classid', 'codebase', 'standby', 'type', 'width', 'height'));
		//additional..
		$this->objectAttributes['id'] = $this->uniqueID;

		$this->paramAttributes = $this->generateAttributeValuesArray(array('src', 'width', 'height'));
		//additional..
		$this->paramAttributes['filename'] = $this->mediaPath;

		$this->embedAttributes = $this->generateAttributeValuesArray(array('name', 'id', 'src', 'width', 'height', 'type', 'pluginspage'));
		//additional..
		$this->embedAttributes['name'] = $this->uniqueID;
		$this->embedAttributes['id'] = $this->uniqueID;


		$XSPF_QueryString_attributes = $this->generateAttributeValuesArray(array('autoplay', 'autoload', 'repeat_playlist', 'player_title', 'info_button_text', 'radio_mode','playlist_size'));

		$XSPF_QueryString_attributes['playlist_url'] = $this->mediaPath ;
		$strXSPF_QueryString = $src."?";
		foreach ($XSPF_QueryString_attributes as $k=>$v) 
		{
			if (strlen(trim($v))> 0)
			$strXSPF_QueryString .= '&'.$k.'='.$v;
		}

		$this->embedAttributes['src'] = $strXSPF_QueryString;
		$this->objectAttributes['movie'] = $strXSPF_QueryString;		
	}

	/**
	 * Function for embedding the audio files associated with Macromedia Flash
	 * @return string formatted HTML embed string
	 */
	public function getEmbedCode( )
	{
		return $this->generateObjectParamEmbedCode();
	}
}

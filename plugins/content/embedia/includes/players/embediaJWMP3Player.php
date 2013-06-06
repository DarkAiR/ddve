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

class embediaJWMP3Player extends embediaPlayerBase 
{
	/**
	 * @see embediaPlayerBase::setupAttributes
	 * @return void :)
	 */
	protected function setupAttributes( )
	{
		$src = $this->playerDecorator->getOverrideAttribute('embediaBaseUrl') . '/includes/players/player.swf';
		//the following arrays will serve as attributes to be populated by the $this->embediaParams
		$this->objectAttributes = $this->generateAttributeValuesArray(array('id', 'classid', 'codebase', 'standby', 'type', 'width', 'height'));
		//additional..
		$this->objectAttributes['id'] = $this->uniqueID;


		$this->paramAttributes = $this->generateAttributeValuesArray(array('width', 'height', 'displayheight', 'logo', 'overstretch', 'shownavigation', 'autostart', 'volume', 'repeat', 'backcolor', 'frontcolor', 'lightcolor', 'largecontrols', 'image', 'title', 'link', 'wmode', 'shuffle'));
		//additional..
		$this->paramAttributes['src'] = $src;
		$this->paramAttributes['filename'] = $this->mediaPath;

		$this->embedAttributes = $this->generateAttributeValuesArray(array('name', 'id', 'src', 'width', 'height', 'type', 'pluginspage', 'wmode', 'allowscriptaccess'), TRUE);
		//additional..
		$this->embedAttributes['src'] = $src;
		$this->embedAttributes['name'] = $this->uniqueID;
		$this->embedAttributes['id'] = $this->uniqueID;
		
		$flashvars_attributes = array('width', 'height', 'displayheight', 'logo', 'overstretch', 'shownavigation', 'autostart', 'volume', 'repeat', 'backcolor', 'frontcolor', 'lightcolor', 'largecontrols', 'image', 'title', 'link', 'wmode', 'shuffle');
		$flashvars_attribute_values = $this->generateAttributeValuesArray(array('width', 'height', 'displayheight', 'logo', 'overstretch', 'shownavigation', 'autostart', 'volume', 'repeat', 'backcolor', 'frontcolor', 'lightcolor', 'largecontrols', 'image', 'title', 'link', 'wmode', 'shuffle'));
		$flashvars_attribute_values['file'] = $this->mediaPath;
		$strflashvars = "";
		foreach ($flashvars_attribute_values as $k=>$v) 
		{
			if (strlen(trim($v))> 0)
			{
				$strflashvars .= '&'.$k.'='.$v;
			}
		}		
		
		$this->embedAttributes['flashvars'] = $strflashvars;
		$this->objectAttributes['flashvars'] = $strflashvars;		
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

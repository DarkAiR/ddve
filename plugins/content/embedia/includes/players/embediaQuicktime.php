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

class embediaQuicktime extends embediaPlayerBase 
{	
	/**
	 * @see embediaPlayerBase::setupAttributes
	 * @return void :)
	 */
	protected function setupAttributes( )
	{
		//the following arrays will serve as attributes to be populated by the $this->embediaParams
		$this->objectAttributes = $this->generateAttributeValuesArray( array('id', 'classid', 'codebase', 'standby', 'type', 'width', 'height'));
		//additional..
		$this->objectAttributes['id'] = $this->uniqueID;

		$this->paramAttributes = $this->generateAttributeValuesArray(array('url', 'src', 'filename', 'movie', 'width', 'height', 'volume', 'cache', 'autoplay', 'scale', 'kioskmode', 'controller', 'loop', 'bgcolor'));
		//additional..
		$this->paramAttributes['url'] = $this->mediaPath;
		$this->paramAttributes['src'] = $this->mediaPath;
		$this->paramAttributes['filename'] = $this->mediaPath;
		$this->paramAttributes['movie'] = $this->mediaPath;		

		$this->embedAttributes = $this->generateAttributeValuesArray(array('name', 'id', 'url', 'src', 'movie', 'filename', 'width', 'height', 'type', 'pluginspage', 'volume', 'cache', 'autoplay', 'scale', 'controller', 'kioskmode', 'loop', 'pluginspage', 'bgcolor'));

		$this->embedAttributes['url'] = $this->mediaPath;
		$this->embedAttributes['src'] = $this->mediaPath;
		$this->embedAttributes['filename'] = $this->mediaPath;
		$this->embedAttributes['movie'] = $this->mediaPath;		
		$this->embedAttributes['name'] = $this->uniqueID;
		$this->embedAttributes['id'] = $this->uniqueID;
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

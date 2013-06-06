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


abstract class embediaPlayerBase
{
	/**
	 *
	 * @var array
	 */
	protected $objectAttributes;

	/**
	 *
	 * @var array
	 */
	protected $paramAttributes;

	/**
	 *
	 * @var array
	 */
	protected $embedAttributes;

	
	/**
	 * Unique ID for the player to be set in session - for popup security
	 *
	 * @var string
	 */
	protected $uniqueID;
	
	
	/**
	 *
	 * @var embediaPlayer
	 */
	protected $playerDecorator;
	
	
	/**
	 * Each player has their own way of creating the string
	 * @return string
	 */
	abstract public function getEmbedCode( );

	/**
	 * Setup the key-value attributes specific to the player
	 * 
	 * @return void ;)
	 */
	abstract protected function setupAttributes();

	/**
	 * File path/url
	 *
	 * @var String
	 */
	protected $mediaPath = "";
	

	/**
	 * Constructor
	 * 
	 *  @param embediaDecorator 
	 */
	public function __construct( embediaDecorator $playerDecorator )
	{
		$this->playerDecorator = $playerDecorator;
		
		$this->mediaPath = $this->playerDecorator->getOverrideAttribute('media');
		$this->uniqueID = $this->playerDecorator->getUniqueID();

		$this->objectAttributes = array();
		$this->paramAttributes = array();
		$this->embedAttributes = array();
		
		$this->setupAttributes();
	}


	/**
	 * Generates a key-value pair array from the valid attribute array with bot params
	 * 
	 * @param array $attributeKeys valid attributes for the OBJECT PARAM or EMBED code
	 * @param boolean $boolAsString quote bools
	 * @return array
	 */
	protected function generateAttributeValuesArray( $attributeKeys )
	{
		$attribute_values = array();
		foreach ($attributeKeys as $attribKey)
		{			
			$value = $this->playerDecorator->getOverrideAttribute($attribKey);
			
			//this is very bizzare but required
			$value = ($value === 'strtrue') ? 'true' : $value;
			$value = ($value === 'strfalse') ? 'false' : $value;

			if (!empty($value))
			{
				$attribute_values[$attribKey] = $value;
			}
		}
		return $attribute_values;
	}


	/**
	 * Finally creates the object/param/embed string
	 *
	 * @return string
	 */
	protected function generateObjectParamEmbedCode( )
	{
		//put together the actual embed HTML
		$strMediaEmbedCode = '<object ';
		$this->objectAttributes['standby'] = 'Please wait...';
		foreach ($this->objectAttributes as $k=>$v) {
			$strMediaEmbedCode .= $k.'="'.$v.'" ';
		}
		$strMediaEmbedCode .= '> ';

		foreach ($this->paramAttributes as $k=>$v) {
			$strMediaEmbedCode .= '<param name="'.$k.'" value="'.$v.'" />';
		}

		$strMediaEmbedCode .= '<embed ';
		foreach ($this->embedAttributes as $k=>$v) {
			$strMediaEmbedCode .= $k.'="'.$v.'" ';
		}
		$strMediaEmbedCode .= '></embed>';
		$strMediaEmbedCode .= '</object>';

		return $strMediaEmbedCode;
	}
}
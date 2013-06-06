<?php
/**
 * @version 3.0.1
 * @package embedia(formerly mosEasyMedia)
 * @copyright Copyright &copy; 2009, Brilaps LLC
 * @author Ozgur Cem Sen
 * @email code@brilaps.com
 * @link http://brilaps.com || http://wiki.brilaps.com
 * @license http://www.opensource.org/licenses/gpl-license.php GNU/GPL v.2 .
 */


/**
 * Parameters handler
 * This class is taken from Mambo Open Source CMS project http://mambo-foundation.org
 */
class mosEmbediaParameters 
{
	
	/** @var object */
	var $_params = null;
	
	/** @var string The raw params string */
	var $_raw = null;
	
	/**
	 * Constructor
	 * 
	 * @param string The raw parms text
	 * @param string Path to the xml setup file
	 */
	public function __construct( $text, $process_sections = false ) 
	{
		$this->_params = $this->parse( $text, $process_sections );
		$this->_raw = $text;
	}
	
	/**
	 * Get the result of parsing the string provided on creation
	 * @return string parsed result
	 */
	public function getParams() {
		return $this->_params;
	}
	
	/**
	 * @param string The name of the param
	 * @param string The value of the parameter
	 * @return string The set value
	 */
	public function set( $key, $value='' ) {
		$this->_params->$key = $value;
		return $value;
	}
	
	/**
	 * Sets a default value if not alreay assigned
	 * @param string The name of the param
	 * @param string The value of the parameter
	 * @return string The set value
	 */
	public function def( $key, $value='' ) {
		return $this->set( $key, $this->get( $key, $value ) );
	}
	
	/**
	 * @param string The name of the param
	 * @param mixed The default value if not found
	 * @return string
	 */
	public function get( $key, $default='' ) {
		if(isset( $this->_params->$key )) return $this->_params->$key === '' ? $default : $this->_params->$key;
		else return $default;
	}
	
	/**
	 * Look to see if string is bracketed by opener and closer
	 * If so, extract and trim the bracketed string
	 * Otherwise, return a null string
	 **/
	public function getBracketed($text, $opener, $closer) {
		if(strlen($text) > 1 AND($text[0] != $opener OR substr($text,-1) != $closer)) return '';
		else return trim(substr($text,1,-1));
	}
	
	/**
	 * Parse an .ini string, based on phpDocumentor phpDocumentor_parse_ini_file function
	 * @param mixed The ini string or array of lines
	 * @param boolean add an associative index for each section [in brackets]
	 * @return object
	 */
	private function parse( $txt, $process_sections = false ) {
		$result = new stdClass();
		if(is_string($txt)) $lines = explode( "\n", $txt );
		elseif(is_array($txt)) $lines = $txt;
		else return $result;

		$sec_name = '';
		$unparsed = 0;

		foreach($lines as $line) {
			// ignore comments and null lines
			$line = trim($line);
			if(strlen($line) == 0 OR $line[0] == ';') continue;

			if($sec_name = $this->getBracketed($line, '[', ']')) {
				if($process_sections) $result->$sec_name = new stdClass();
				continue;
			}

			if(count($propsetter = explode('=', $line, 2)) == 2) {
				$property = trim($propsetter[0]);
				if($pquoted = $this->getBracketed($property, '"', '"')) $property = stripcslashes($pquoted);
				$value = trim($propsetter[1]);
				if($value == 'false') $value = false;
				elseif($value == 'true') $value = true;
				else if($vquoted = $this->getBracketed($value, '"', '"')) $value = stripcslashes($vquoted);
				if($process_sections AND $sec_name) $result->$sec_name->$property = $value;
				else $result->$property = $value;
			}
			else {
				$property = '__invalid' . $unparsed++ . '__';
				if($process_sections AND $sec_name) $result->$sec_name->$property = $line;
				else $result->$property = $line;
			}
		}
		return $result;
	}
}

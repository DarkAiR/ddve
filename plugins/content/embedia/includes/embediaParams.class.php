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
 * A trimmed down version on class mosParameters in core.classes.php in Mambo CMS project
 * The entry point of the embedia utilizer application will populate the param array,so that
 * this array can be used generically across embedia
 * A simple key => value pair getter/setter class
 */
class embediaParams 
{

	/** @var object */
	var $_params = array();


	/**
	 * Sets the parameters.. parser code sets this key => value array
	 * @return string parsed result
	 */
	function setParams( $params ) {
		foreach($params as $key=>$value) {
			$this->_params[strtolower($key)] = $value;
		}
	}

	/**
	 * Get the result of parsing the string provided on creation
	 * @return string parsed result
	 */
	function getParams( ) {
		return $this->_params;
	}
	/**
	 * @param string The name of the param
	 * @param string The value of the parameter
	 * @return string The set value
	 */
	function set( $key, $value='' ) {
		$this->_params[strtolower($key)] = $value;
		return $value;
	}
	/**
	 * Sets a default value if not alreay assigned
	 * @param string The name of the param
	 * @param string The value of the parameter
	 * @return string The set value
	 */
	function def( $key, $value='' ) {
		return $this->set($key, $this->get( $key, $value ) );
	}
	/**
	 * @param string The name of the param
	 * @param mixed The default value if not found
	 * @return string
	 */
	function get( $key, $default='' ) {
		if (isset($this->_params[strtolower($key)])) return $this->_params[strtolower($key)] === '' ? $default : $this->_params[strtolower($key)];
		else return $default;
	}
}

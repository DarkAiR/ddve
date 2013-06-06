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


class embediaJsCssLoader
{
	private static $instance;

	/**
	 * @var array
	 */
	private $js;
	
	/**
	 * 
	 * @var array
	 */
	private $css;

	/**
	 * Constructor
	 *
	 * @return embediaJsCssLoader
	 */
	private function __construct()
	{
		$this->js 	= array();
		$this->css 	= array();
	}


	/**
	 * Singleton
	 *
	 * return embediaJsCssLoader
	 */
	public static function getInstance()
	{

		if (!isset(self::$instance)) {
			self::$instance = new embediaJsCssLoader;
		}

		return self::$instance;
	}

	/**
	 * Adds a javascript file path in the embediaJsCssLoader::js
	 *
	 * @param String $js
	 * @return
	 */
	public function addJs($js)
	{
		if (!array_key_exists($js, $this->js))
		{
			$this->js[$js] = array('loaded' => false) ;
		}
	}

	/**
	 * Adds a css file path in the embediaJsCssLoader::css
	 *
	 * @param String $js
	 * @return
	 */
	public function addCss($css, $withJs = false)
	{
		if (!array_key_exists($css, $this->css))
		{
			$this->css[$css] = array('withJs' => $withJs, 'loaded' => false) ;
		}
	}


	/**
	 * Implodes the embediaJsCssLoader::css into an HTML string and puts before the <head>
	 *
	 * @return
	 */
	public function insertCssFiles()
	{
		$code = '';
		foreach ($this->css as $css => $params)
		{
			if (!empty($params['withJs']) && ($params['loaded'] === false))
			{
				$code .=  <<<EMBEDIACSS
            				<script type="text/javascript"> 
            					// <![CDATA[ 
            						embedia.addCssUrl("$css");     
            					// ]]>
            				</script>
EMBEDIACSS;
				$this->css[$css]['loaded'] = true;
			}
			else if ($params['loaded'] === false)
			{
				$code .= '<link rel="stylesheet" type="text/css" media="screen" href="' . $css . '"/>';
				$this->css[$css]['loaded'] = true;
			}

		}
		return $code;
	}

	/**
	 * Implodes the embediaJsCssLoader::js into an HTML string and puts before the <head>
	 *
	 * @return String
	 */
	public function insertJsFiles()
	{
		$code = '';
		if (!empty($this->js))
		{
			foreach ($this->js as $js => $params)
			{
				if ($params['loaded'] === false)
				{
					$code .= '<script type="text/javascript" src="' . $js . '"></script>';
					$this->js[$js]['loaded'] = true;
				}
			}
		}
		return $code;
	}
	
	
	public function setLoaded($file, $isSet = true) 
	{
		if (isset($this->js[$file]))
		{
			$this->js[$file] = $isSet;
		}
		
		if (isset($this->css[$file]))
		{
			$this->css[$file] = $isSet;
		}		
		
	}

	public function __clone()
	{
		trigger_error('do not mess with embedia!', E_USER_ERROR);
	}
}

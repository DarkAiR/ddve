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

spl_autoload_register(null, false);
spl_autoload_extensions('.php');


if (spl_autoload_functions() !== false && function_exists('__autoload'))
{
	spl_autoload_register('__autoload', false);
}


/**
 * Load classes under includes
 * 
 * @param String $class_name

 */
function _autoloadCommons( $class_name )
{
	$class_path = dirname(__FILE__) . "/includes/$class_name.class.php";

	if (file_exists($class_path))
	{
		require_once $class_path;
	}
	else
	{
		$class_path = dirname(__FILE__) . "/includes/$class_name.php";
		if (file_exists($class_path))
		{
			require_once $class_path;
		}
		else
		{
			$class_path = dirname(__FILE__) . "/includes/$class_name.inc.php";
			if (file_exists($class_path))
			{
				require_once $class_path;
			}
			else 
			{
				$class_path = dirname(__FILE__) . "/includes/$class_name.interface.php";
				if (file_exists($class_path))
				{
					require_once $class_path;
				}			
			}
			// else forget it :)
		}
	}
}

/**
 * Load player classes
 * 
 * @param $class_name
 */
function _autoloadPlayers( $class_name )
{
	$class_path = dirname(__FILE__) . "/includes/players/$class_name.class.php";

	if (file_exists($class_path))
	{
		require_once $class_path;
	}
	else
	{
		$class_path = dirname(__FILE__) . "/includes/players/$class_name.php";
		if (file_exists($class_path)) 
		{
			require_once $class_path;
		}
		// else forget it!
	}
}

spl_autoload_register('_autoloadCommons');
spl_autoload_register('_autoloadPlayers');

require_once (dirname(__FILE__) . '/includes/defaults.php');

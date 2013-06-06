<?php
// updated 26 Jan 2009

	defined('_JEXEC') or die('Restricted access');
	global $joomlusModCount,$joomlushelper_instance;
	//set number of times a this module is called. Stops javascript confilcts.
	$joomlusModCount += 1;
	//get all module params conveiently in one array
	$paramsArry = $params->toArray();
	//check instance of helper class, basic singleton
	if (!is_object($joomlushelper_instance)) {
        // does not currently exist, so create it
        require_once (dirname(__FILE__).DS.'helper.php');
		$mainframe->addCustomHeadTag("<!--[if IE]></base><![endif]-->");
    }
    $joomlushelper_instance = new joomulusHelper($paramsArry);
	$tagwords = $joomlushelper_instance->joomulus_tagwords_sd();
	$altdiv = $joomlushelper_instance->joomulus_altdiv_sd($tagwords);
	$flashvars = $joomlushelper_instance->joomulus_flashvars_sd($tagwords);
	
	echo $joomlushelper_instance->joomulus_createflashcode($tagwords, $altdiv, $flashvars);

?>






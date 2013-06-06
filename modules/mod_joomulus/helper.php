<?php
// updated 11 May 2009
// by Joomlabears
defined('_JEXEC') or die('Restricted access');

class joomulusHelper {

	var $options;
	
	// gets module params
	function joomulusHelper($option) {
		$this->options = $option;
	}

//*********************** tags from module parameters
	function joomulus_tagwords_sd () { // build tagwords from SD list
		$tagcloud2 ='';
		$tagcloud = '<tags>';
		for($count = 1; $count <= 30; $count++) { // 20 is the number of tag parameters in the module backend
			if ($this->options[$count.'_name'] != null) {
				$tagcloud2 .= "<a href='".$this->options[$count.'_url']."' target='".$this->options['target']."' style='font-size:".$this->options[$count.'_size']."'>".$this->options[$count.'_name']."</a>\n ";
			}
			else
				break;
		}
		if (trim($tagcloud2)=='') {
			$tagcloud2 = "<a href='".JURI::base()."' target='".$this->options['target']."' style='font-size:20'>NOTHINGFOUND</a>\n ";
		}
		$tagcloud .= $tagcloud2.'</tags>';
		return $tagcloud;
	}
	function joomulus_altdiv_sd ($tags) { // build alternative div content (only contents inside the div!!!)
		return '<p>'.$tags.'</p>';
	}
	function joomulus_flashvars_sd($tags) { // build specific flashvars for this mode
		$tagcloud2 = 'mode: "tags", ';
		$tagcloud2 .= 'tagcloud: "'. urlencode($tags) . '" ';
		return $tagcloud2;	
	}

//******************* build flash HTML with SWFobject 
	function joomulus_createflashcode($tags, $altdiv, $subflashvars ) {
		global $joomlusModCount;
		global $mainframe;
		$name = 'modJoomulus';
		$version = $name.' 1.0.7.6';
		$soname = $name.'Instance';
		$divname = $name.$joomlusModCount;
		$flashtag='';
		$chaine='';
		//gets SWF based on user params
		$mainframe->addCustomHeadTag("\n<!-- SWFObject embed by Geoff Stearns geoff@deconcept.com http://blog.deconcept.com/swfobject/ -->");
		if ($this->options['swfobject']!='0') {
			$mainframe->addCustomHeadTag("\n<script type=\"text/javascript\" src=\"".JURI::base()."modules/mod_joomulus/swfobject.js\" ></script>\n");
		}		
		$movie = JURI::base().'modules/mod_joomulus/tagcloud'.$this->options['language'].'.swf';

		// load  expressinstall.swf file,  ideally this would be  module parameter .. 
		$expressinstall = '"'.JURI::base().'modules/mod_joomulus/expressinstall.swf"';
	
		// add alternate div contents
		$chaine .= '<div class="modJoomulus_'.$this->options['moduleclass_sfx'].'" id="'.$divname.'">' . $altdiv . '</div>';
		
		$flashtag .= '<script type="text/javascript" >';
		$flashtag .= '	var flashvars = {';
		if ( $this->options['distr'] == '1' ) { $flashtag .= 'distr: "true",'; } else { $flashtag .= 'distr: "false",'; }
		$flashtag .= 'tcolor: "0x'.$this->options['tcolor'].'",';
		if ( $this->options['tcolor2'] == "" ) { $flashtag .= 'tcolor2: "0x'.$this->options['tcolor'].'",'; } else { $flashtag .= 'tcolor2: "0x'.$this->options['tcolor2'].'",'; }
		$flashtag .= 'hicolor: "0x'.$this->options['hicolor'].'",';
		$flashtag .= 'tspeed: "'.$this->options['speed'].'",';
		$flashtag .= 'scale_x: "'.$this->options['scale_x'].'",';
		$flashtag .= 'scale_y: "'.$this->options['scale_y'].'",';
		// add mode-specific flashvars and close flashvars section
		$flashtag .= $subflashvars . '}; ';
		$flashtag .= '	var params = {';
		if ( $this->options['trans'] == '1' ) { $flashtag .= 'wmode: "transparent",'; }
		$flashtag .= 'bgcolor: "'.$this->options['bgcolor'].'",';
		$flashtag .= 'allowscriptaccess: "sameDomain"';
		$flashtag .= '};';
		$flashtag .= ' var attributes = {';
		$flashtag .= '};';
		$flashtag .= ' var rnumber = Math.floor(Math.random()*9999999);'; // force loading of movie to fix IE weirdness
		$flashtag .= ' swfobject.embedSWF("'.$movie.'?r="+rnumber, "'.$divname.'", "'.$this->options['width'].'", "'.$this->options['height'].'", "9.0.115",'.$expressinstall.', flashvars, params, attributes);';
		$flashtag .= '</script>';
		// adds javascript to head page for loading joomulus SWF
		$mainframe->addCustomHeadTag("\n". $flashtag."\n");
		return $chaine;
	}
}	
?>
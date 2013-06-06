<?php 
/**
* @Copyright Copyright (C) 2008 - 2010 IceTheme
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
******/


abstract class modIceVMCartHelp {
	
	/**
	 * get list articles
	 */
	public static function getList( $params ){
		
	}
	
	/**
	 * get list articles
	 */
	public static function getGroupObject( $params ){
	
	}
        
	/**
	 * render Item Layout.
	 */
	public function renderItem( &$row, $params, $layout='_item' ){
		$target = $params->get('open_target','_parent') != 'modalbox'
							? 'target="'.$params->get('open_target','_parent').'"'
							: 'rel="'.$params->get('modal_rel','width:800,height:350').'" class="mb"'; 
	
		$path = dirname(__FILE__).DS.'themes'.DS.$params->get('theme').DS;
		if( file_exists($path.$params->get('group').$layout.'.php') ){
			require( $path.$params->get('group').$layout.'.php' );
			return ;
		}
		require( $path.$layout.'.php' );
	}
	
	/**
	 * load css - javascript file.
	 * 
	 * @param JParameter $params;
	 * @param JModule $module
	 * @return void.
	 */
	public static function loadMediaFiles( $params, $module, $theme='' ){
	
		global $mainframe;
		$template = self::getTemplate();
		//load style of module
		if(file_exists(JPATH_BASE.DS.'templates/'.$template.'/css/'.$module->module.'.css')){
			JHTML::stylesheet(  $module->module.'.css','templates/'.$template.'/css/' );		
		}			
		// load style of theme follow the setting
		if( $theme && $theme != -1 ){
			$tPath = JPATH_BASE.DS.'templates'.DS.$template.DS.'css'.DS.$module->module.'_'.$theme.'.css';
			if( file_exists($tPath) ){
				JHTML::stylesheet( $module->module.'_'.$theme.'.css','templates/'.$template.'/css/');
			} else {
				JHTML::stylesheet('style.css',JURI::base().'modules/'.$module->module.'/themes/'.$theme.'/assets/');	
			}
		} else {
           JHTML::stylesheet( 'style.css', JURI::base().'modules/'.$module->module.'/assets/' );
		}
					
		JHTML::script( 'script.js',JURI::base().'modules/'.$module->module.'/assets/' );
	}
	
	/**
	 *
	 */
	public static function getTemplate(){
		if(JVersion::isCompatible('1.6.0') ){
			$app = JFactory::getApplication();
			return $app->getTemplate();
		}
		global $mainframe;
		return $mainframe->getTemplate();
	}
	/**
	 * load theme
	 */
	public static function getLayoutByTheme( $module, $group, $theme= '' ){
		global $mainframe;		
		$layout = 'default';
		if( $theme ) {
			$layout = $group.DS.trim($theme).'_default';	
		}
		
		
		// Build the template and base path for the layout
		$tPath = JPATH_BASE.DS.'templates'.DS.self::getTemplate().DS.'html'.DS.$module->module.DS.$layout.'.php';
		$bPath = JPATH_BASE.DS.'modules'.DS.$module->module.DS.'tmpl'.DS.$layout.'.php';

		// If the template has a layout override use it
		if (file_exists($tPath)) {
			return $tPath;
		} elseif( file_exists($bPath) ) {
			return $bPath;
		}
		return JPATH_BASE.DS.'modules'.DS.$module->module.DS.'themes'.DS.$theme.DS.'default.php';
	}
}
?>
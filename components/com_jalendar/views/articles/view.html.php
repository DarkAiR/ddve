<?php
/**
* @Copyright Copyright (C) 2010- BMForce
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
 
class jalendarViewArticles extends JView
{
 
	function display($tpl = null)
    {
	
		$model =&$this->getModel();
		$user=& JFactory::getUser();
		require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
		require_once (JPATH_SITE.DS.'components'.DS.'com_jalendar'.DS.'icon.php');
		require_once('administrator/components/com_jalendar/config.php');
		$language =& JFactory::getLanguage();
		$language->load('com_content');
		JRequest::setVar('option','com_content');
		$config=new JalendarConfig();
	
		$day = (int) JRequest::getVar('day');
		$month = (int) JRequest::getVar('month');
		$year = (int) JRequest::getVar('year');
	
		jimport('joomla.html.pagination');
	
		$limitstart=(int) JRequest::getVar('limitstart');
	 
		if ($config->a_type)
		{
		
			$total = $model->getallarticle_l($day,$month,$year,$config);

			if ($limitstart<=$total) $alist = $model->getarticle_l($day,$month,$year,$config,$limitstart);
		}

		if (!$config->a_type || $config->a_type==2)
		{
			$total_d = $model->getallarticle_d($day,$month,$year,$config);

			if (count($alist)<$config->a_page && $limitstart) 
			{
				if (count($alist)) $dif=$config->a_page-count($alist);
				$alist_d = $model->getarticle_d($day,$month,$year,$config,($limitstart+$dif-$total),($config->a_page-count($alist)));
			} else if (count($alist)<$config->a_page && !$limitstart) $alist_d = $model->getarticle_d($day,$month,$year,$config,0,($config->a_page-count($alist)));
		}

		 $this->pagination=& new JPagination($total+$total_d, $limitstart, $config->a_page);
		 
		if (!$config->type)
		$content = $model->getpage($alist_d,$alist,$config,$this->pagination);
		else 
		{
			$params = new JParameter ($params);
			$params->set('show_title', 1);
			$params->set('show_page_title', 1);
			//$params->set('show_intro', 1);
			$params->set('link_titles', $config->title_link);
			$params->set('show_pdf_icon', $config->pdf_icon );
			$params->set('show_print_icon', $config->print_icon );
			$params->set('show_email_icon', $config->email_icon );
			$params->set('show_icons', $config->icon_v );
			$params->set('show_modify_date', $config->mdate_v );
			$params->set('show_create_date', $config->crdate_v );
			$params->set('show_author', $config->username_v );
			$params->set('show_section', $config->section_v);
			$params->set('link_section', $config->section_link);
			$params->set('show_category', $config->category_v);
			$params->set('link_category', $config->category_link);
			$params->set('show_readmore', $config->readmore_v);
			$params->set('num_columns', 1);
			$params->set('num_links', 0);
			$params->set('num_leading_articles', 0);
			$params->set('num_intro_articles', $config->a_page);
		}

		$document	=& JFactory::getDocument();
		$print = JRequest::getBool('print');
		if ($print) 
		{
			$document->setMetaData('robots', 'noindex, nofollow');
		}
	
		$access				= new stdClass();
		$access->canEdit	= $user->authorize('com_content', 'edit', 'content', 'all');
		$access->canEditOwn	= $user->authorize('com_content', 'edit', 'content', 'own');
		$access->canPublish	= $user->authorize('com_content', 'publish', 'content', 'all');
       
	  
	   
		$this->assignRef( 'content', $content);
		$this->assignRef( 'user', $user);
		$this->assignRef( 'params', $params);
		$this->assignRef( 'alist', $alist);
		$this->assignRef( 'alist_d', $alist_d);
		$this->assignRef( 'config', $config);
		$this->assignRef('access', $access);
		$this->assignRef('print', $print);
		$this->assign('total',$total);
		$this->assign('total_d',$total_d);
		$this->assign('limitstart',$limitstart);
		
        parent::display($tpl);
    }
	
	function &getItem($index = 0, &$params)
	{
		global $mainframe;


		$user		=& JFactory::getUser();
		$dispatcher	=& JDispatcher::getInstance();

		$item =& $this->alist[$index-$this->limitstart];
	
		$item->text=$item->introtext;
		$item->section = $item->stitle;
		$item->category = $item->cattitle;
		$item->catslug = $item->catid.':'.$item->catslug;
		$item->slug = $item->id.':'.$item->slug;
		$item->state=1;

		$item->readmore_link =JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug, $item->sectionid));

		$item->params = clone($params);
		$aparams = new JParameter($item->attribs);

		$item->params->merge($aparams);

		JPluginHelper::importPlugin('content');
		$results = $dispatcher->trigger('onPrepareContent', array (& $item, & $item->params, 0));

		$item->event = new stdClass();
		$results = $dispatcher->trigger('onAfterDisplayTitle', array (& $item, & $item->params,0));
		$item->event->afterDisplayTitle = trim(implode("\n", $results));

		$results = $dispatcher->trigger('onBeforeDisplayContent', array (& $item, & $item->params, 0));
		$item->event->beforeDisplayContent = trim(implode("\n", $results));

		$results = $dispatcher->trigger('onAfterDisplayContent', array (& $item, & $item->params, 0));
		$item->event->afterDisplayContent = trim(implode("\n", $results)); 

		return $item;
	}
}
 
?>

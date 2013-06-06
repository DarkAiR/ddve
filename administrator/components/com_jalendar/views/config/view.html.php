<?php
/**
* @Copyright Copyright (C) 2010- BMForce
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class jalendarViewconfig extends JView
{
    function display($tpl = null)
    {
		GLOBAl $mainframe;
		$model =& $this->getModel();
		$layout	= JRequest::getVar('layout');
		$document =& JFactory::getDocument();
		
		if ( $layout=='config' )
		{		
			JToolBarHelper::title( JText::_( 'Jalendar' ), 'generic.png' );
	
			JToolBarHelper::save('saveconfig',JText::_( 'Save' ));
		
			require(JPATH_COMPONENT.DS.'config.php');
			$config=new JalendarConfig();

			$type = array(
			JHTML::_('select.option',  '0', JText::_( 'Date, time and title' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Standard view' ) ),
			);

			$this->type=JHTML::_('select.genericlist',   $type, 'type', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->type);
	
			$pldate = array(
			JHTML::_('select.option',  '0', JText::_( 'Date before of each article' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Date and time before of each article' ) ),
			JHTML::_('select.option',  '2', JText::_( 'Date before each group of articles and time before of each article' ) ),
			JHTML::_('select.option',  '3', JText::_( 'Date before each group of articles' ) )
			);

			$this->pldate=JHTML::_('select.genericlist',   $pldate, 'pldate', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->pldate );
		
				$uncat = array(
			JHTML::_('select.option',  '0', JText::_( 'No' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Yes' ) ),
			);

			$this->uncat=JHTML::_('select.genericlist',   $uncat, 'uncat', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->uncat );

			$this->id_category='<textarea name="id_category" cols="40" rows="3">'.$config->id_category.'</textarea>';
		
			$this->id_section='<textarea name="id_section" cols="40" rows="3">'.$config->id_section.'</textarea>';
			$this->id_article='<textarea name="id_article" cols="40" rows="3">'.$config->id_article.'</textarea>';
		
				$icon_v = array(
			JHTML::_('select.option',  '0', JText::_( 'Hide' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Show' ) ),
			);

			$this->icon_v=JHTML::_('select.genericlist',   $icon_v, 'icon_v', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->icon_v );
		
				$pdf_icon = array(
			JHTML::_('select.option',  '0', JText::_( 'Hide' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Show' ) ),
			);

			$this->pdf_icon=JHTML::_('select.genericlist',   $pdf_icon, 'pdf_icon', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->pdf_icon );
		
				$email_icon = array(
			JHTML::_('select.option',  '0', JText::_( 'Hide' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Show' ) ),
			);

			$this->email_icon=JHTML::_('select.genericlist',   $email_icon, 'email_icon', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->email_icon );
		
				$print_icon = array(
			JHTML::_('select.option',  '0', JText::_( 'Hide' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Show' ) ),
			);

			$this->print_icon =JHTML::_('select.genericlist',   $print_icon , 'print_icon', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->print_icon );
	

			$section_v = array(
			JHTML::_('select.option',  '0', JText::_( 'Hide' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Show' ) ),
			);

			$this->section_v =JHTML::_('select.genericlist',   $section_v , 'section_v', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->section_v );
		
			$section_link = array(
			JHTML::_('select.option',  '0', JText::_( 'No' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Yes' ) ),
			);

			$this->section_link =JHTML::_('select.genericlist',   $section_link , 'section_link', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->section_link );
		
			$category_v = array(
			JHTML::_('select.option',  '0', JText::_( 'Hide' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Show' ) ),
			);

			$this->category_v =JHTML::_('select.genericlist',   $category_v , 'category_v', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->category_v );
		
			$category_link = array(
			JHTML::_('select.option',  '0', JText::_( 'No' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Yes' ) ),
			);

			$this->category_link =JHTML::_('select.genericlist',   $category_link , 'category_link', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->category_link );
		
			$username_v  = array(
			JHTML::_('select.option',  '0', JText::_( 'Hide' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Show' ) ),
			);

			$this->username_v  =JHTML::_('select.genericlist',   $username_v  , 'username_v', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->username_v );
		
			$username_t = array(
			JHTML::_('select.option',  'Name', JText::_( 'Name' ) ),
			JHTML::_('select.option',  'Username', JText::_( 'Username' ) ),
			);

			$this->username_t =JHTML::_('select.genericlist',   $username_t , 'username_t', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->username_t );
		
			$crdate_v= array(
			JHTML::_('select.option',  '0', JText::_( 'Hide' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Show' ) ),
			);

			$this->crdate_v =JHTML::_('select.genericlist',   $crdate_v , 'crdate_v', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->crdate_v);
		
			$mdate_v  = array(
			JHTML::_('select.option',  '0', JText::_( 'Hide' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Show' ) ),
			);

			$this->mdate_v  =JHTML::_('select.genericlist',   $mdate_v  , 'mdate_v', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->mdate_v  );
		
			$readmore_v = array(
			JHTML::_('select.option',  '0', JText::_( 'Hide' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Show' ) ),
			);

			$this->readmore_v =JHTML::_('select.genericlist',   $readmore_v , 'readmore_v', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->readmore_v );
		
			$title_link = array(
			JHTML::_('select.option',  '0', JText::_( 'No' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Yes' ) ),
			);

			$this->title_link =JHTML::_('select.genericlist',   $title_link , 'title_link', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->title_link );
		
			$this->a_page='<input name="a_page" value="'.$config->a_page.'" type="text" style="width:30px;" />';
		
			$a_type = array(
			JHTML::_('select.option',  '0', JText::_( 'Only articles by publication date' ) ),
			JHTML::_('select.option',  '1', JText::_( 'Only linkage articles' ) ),
			JHTML::_('select.option',  '2', JText::_( 'Both' ) ),
			);

			$this->a_type =JHTML::_('select.genericlist',   $a_type , 'a_type', 'size="1" class="inputbox" style="width:150px;"', 'value', 'text', $config->a_type );
		}
		if ( $layout=='conj' ) 
		{
		
			$limit	= JRequest::getVar('limit',	$mainframe->getCfg('list_limit'),	'', 'int');
			$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		
			JToolBarHelper::title( JText::_( 'Jalendar' ), 'generic.png' );
			
			JToolBarHelper::custom( 'back', 'back.png', 'back_f2.png', JText::_( 'back' ), false );
			JToolBarHelper::custom( 'add', 'new.png', 'new_f2.png', JText::_( 'NEW' ), false );
			JToolBarHelper::editListX( 'edit' );
			JToolBarHelper::customX( 'delete', 'delete.png', 'delete_f2.png', JText::_( 'Delete' ), true );

			$articledates=$model->getarticledates($limitstart,$limit);
			$allarticledates=$model->getallarticledates();

			jimport('joomla.html.pagination');
			$pagination = new JPagination($allarticledates, $limitstart, $limit);
			$this->assignRef( 'articledates', $articledates );
			$this->assignRef( 'pagination', $pagination );
		} 
			
		if ( $layout=='edit' ) 
		{
			echo JHTML::_( 'behavior.calendar' );
			$articledate=$model->getarticledate();
			$allarticles=$model->allarticles();
			if (!empty($category)) JToolBarHelper::title( JText::_( 'EDIT Pryvyazka' ) );
			else
				JToolBarHelper::title(  JText::_( 'ADD Privyazka' ) );
			JToolBarHelper::custom( 'save', 'save.png', 'save_f2.png', JText::_( 'save' ), false );
			JToolBarHelper::cancel();
			$this->assignRef( 'articledate', $articledate );
			$this->assignRef( 'allarticles', $allarticles );
		}
	
        parent::display($tpl);
    }
}

?>
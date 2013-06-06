<?php
/**
* @Copyright Copyright (C) 2010- BMForce
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class JalendarModelConfig extends JModel
{

	function getarticledates($limitstart,$limit)
	{
		$query="SELECT j.*,c.title FROM #__jalendar as j INNER JOIN #__content as c WHERE j.id_article=c.id LIMIT ".$limitstart.", ".$limit;
		$art=$this->_getList($query);

		return $art;
	}

	function getallarticledates()
	{
		$db =& JFactory::getDBO();
		$query="SELECT * FROM #__jalendar";
		$total=count($this->_getList( $query ));
		return $total;
	}

	function getarticledate()
	{
		$category = JRequest::getVar('cid',  0, '', 'array');
		$id=(int)$category[0];

		$query="SELECT j.*,c.title FROM #__jalendar as j INNER JOIN #__content as c WHERE j.id_article=c.id AND j.id=".$id;
		$this->_db->setQuery($query);
		$art=$this->_db->loadObject($query);
		return $art;
	}

	function allarticles()
	{

		$query="SELECT c.title, c.id FROM #__content as c";
		$art=$this->_getList($query);
		return $art;
	}

	function save()
	{
		$data = JRequest::get( 'post' );
		$db =& JFactory::getDBO();
		$query = "REPLACE INTO `#__jalendar` ( `id` , `id_article`, `date`, `type` )
		VALUES (
		'".$data['jid']."', '".$data['articlelist']."', '".$data['adate']."', '".$data['typedate']."');
		";
			$db->setQuery( $query );
			$db->query();

		return true;
	}

	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		
		$str = implode(',',$cids);
		
		$query = "DELETE j
			FROM #__jalendar as j
			WHERE j.id IN (".$str.");";
		$this->_db->setQuery( $query );
		$this->_db->query();
		return true;
	}


	function saveconfig()
	{
		$data = JRequest::get( 'post' );
		$config = new JRegistry('config');

		$config_array = array();

		$config_array['type']= !empty($data['type'])?1:0;
		$config_array['pldate']= $data['pldate'];
		$config_array['uncat']= !empty($data['uncat'])?1:0;
		$config_array['id_category']= $data['id_category'];
		$config_array['id_section']= $data['id_section'];
		$config_array['id_article']= $data['id_article'];
		$config_array['icon_v']= !empty($data['icon_v'])?1:0;
		$config_array['pdf_icon']= !empty($data['pdf_icon'])?1:0;
		$config_array['email_icon']= !empty($data['email_icon'])?1:0;
		$config_array['print_icon']= !empty($data['print_icon'])?1:0;
		$config_array['section_v']= !empty($data['section_v'])?1:0;
		$config_array['section_link']= !empty($data['section_link'])?1:0;
		$config_array['category_v']= !empty($data['category_v'])?1:0;
		$config_array['category_link']= !empty($data['category_link'])?1:0;
		$config_array['username_v']= !empty($data['username_v'])?1:0;
		$config_array['username_t']= $data['username_t'];
		$config_array['crdate_v']= !empty($data['crdate_v'])?1:0;
		$config_array['mdate_v']= !empty($data['mdate_v'])?1:0;
		$config_array['readmore_v']= !empty($data['readmore_v'])?1:0;
		$config_array['title_link']= !empty($data['title_link'])?1:0;
		$config_array['a_page']= $data['a_page'];
		$config_array['a_type']= $data['a_type'];


		$config->loadArray($config_array);

		$fname = JPATH_CONFIGURATION.DS.'administrator'.DS.'components'.DS.'com_jalendar'.DS.'config.php';
		jimport('joomla.filesystem.path');

		if (!$ftp['enabled'] && JPath::isOwner($fname) && !JPath::setPermissions($fname, '0644')) 
		{
			JError::raiseNotice('SOME_ERROR_CODE', 'Could not make config.php writable');
		}

		jimport('joomla.filesystem.file');
		if (JFile::write($fname, $config->toString('PHP', 'config', array('class' => 'JalendarConfig')))) {
			$msg = JText::_( 'The Configuration Details have been updated' );
		} else {
			$msg = JText::_( 'ERRORCONFIGFILE' );
		}

		return true;
	}

}

?>
<?php
/**
* @Copyright Copyright (C) 2010- BMForce
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die();
 
jimport( 'joomla.application.component.model' );
 
class jalendarModelArticles extends JModel
{

	function getallarticle_l($day,$month,$year,$config)
    {
		$user = &JFactory::getUser();
		
		$where='('.$this->cwhere2($day,$month,$year,$config).')';
	
		$query = "SELECT c.id
			FROM #__jalendar as j 
			INNER JOIN #__content as c ON j.id_article = c.id 
			INNER JOIN #__users as a ON a.id = c.created_by 
			LEFT JOIN #__sections as s ON s.id = c.sectionid 
			LEFT JOIN #__categories as cat ON cat.id = c.catid 
			WHERE ((c.publish_down='0000-00-00 00:00:00' OR c.publish_down>=NOW()) 
			AND c.state=1 AND c.access<=".$user->aid." AND ((s.published = 1 AND cat.published = 1 AND s.access<=".$user->aid." AND cat.access<=".$user->aid." AND c.sectionid<>0) OR (c.sectionid=0))) 
			AND ".$where."
			ORDER BY c.publish_up DESC";
		$this->_db->setQuery( $query );
		$count=count($this->_db->loadObjectList());
	
		return $count;
	}
	function getallarticle_d($day,$month,$year,$config)
    {
		$user = &JFactory::getUser();
		if ($config->uncat) $uncat="OR (c.sectionid=0)";
		$where='('.$this->cwhere($day,$month,$year,$config).')';
	
		$query = "SELECT c.id
			FROM #__content as c
			INNER JOIN #__users as a ON a.id = c.created_by 
			LEFT JOIN #__sections as s ON s.id = c.sectionid 
			LEFT JOIN #__categories as cat ON cat.id = c.catid 
			WHERE ((c.publish_down='0000-00-00 00:00:00' OR c.publish_down>=NOW()) 
			AND c.state=1 AND c.access<=".$user->aid." AND ((s.published = 1 AND cat.published = 1 AND s.access<=".$user->aid." AND cat.access<=".$user->aid." AND c.sectionid<>0) ".$uncat.")) 
			AND ".$where."
			ORDER BY c.publish_up DESC";
		$this->_db->setQuery( $query );
		$count=count($this->_db->loadObjectList());
	
		return $count;
	}

	
	function getarticle_l($day,$month,$year,$config,$limitstart)
    {
		$user = &JFactory::getUser();

		$where='('.$this->cwhere2($day,$month,$year,$config).')';
	
		if (!$config->type)
		{
			switch ($config->pldate) 
			{
				case 0:
					$select="DATE_FORMAT(j.date,'%Y-%m-%d') as cdatetime";
					break;
				case 1:
					$select="DATE_FORMAT(c.publish_up,CONCAT(DATE_FORMAT(j.date,'%Y-%m-%d'),' %H:%i')) as cdatetime";
					break;
				case 2:
					$select="DATE_FORMAT(c.publish_up,'%H:%i') as cdatetime, DATE_FORMAT(j.date,'%d-%m-%Y') as cdate";
					break;
				case 3:
					$select="DATE_FORMAT(j.date,'%d-%m-%Y') as cdate";
					break;
			}
		} else $select="c.publish_up as created, 
		c.introtext, c.fulltext, c.modified, s.title as stitle, c.alias as slug, cat.alias as catslug, 
		cat.title as cattitle, a.".$config->username_t." as author, c.created_by_alias, c.attribs, CHAR_LENGTH( c.fulltext ) as readmore ";
	
		$query = "SELECT c.title, ".$select." , c.id, c.catid, c.sectionid 
			FROM #__jalendar as j 
			INNER JOIN #__content as c ON j.id_article = c.id 
			INNER JOIN #__users as a ON a.id = c.created_by 
			LEFT JOIN #__sections as s ON s.id = c.sectionid 
			LEFT JOIN #__categories as cat ON cat.id = c.catid 
			WHERE ((c.publish_down='0000-00-00 00:00:00' OR c.publish_down>=NOW()) 
			AND c.state=1 AND c.access<=".$user->aid." AND ((s.published = 1 AND cat.published = 1 AND s.access<=".$user->aid." AND cat.access<=".$user->aid." AND c.sectionid<>0) OR (c.sectionid=0))) 
			AND ".$where."  
			ORDER BY j.date DESC, DATE_FORMAT(c.publish_up,'%H:%i') DESC";

		$this->_db->setQuery( $query,  $limitstart, $config->a_page);
		$alist=$this->_db->loadObjectList();	
		return $alist;
	}

	function getarticle_d($day,$month,$year,$config,$limitstart,$count)
    {
		$user = &JFactory::getUser();
		if ($config->uncat) $uncat="OR (c.sectionid=0)";
		$where='('.$this->cwhere($day,$month,$year,$config).')';
	
		if (!$config->type)
		{
			switch ($config->pldate) 
			{
				case 0:
					$select="DATE_FORMAT(c.publish_up,'%Y-%m-%d') as cdatetime";
					break;
				case 1:
					$select="DATE_FORMAT(c.publish_up,'%Y-%m-%d %H:%i') as cdatetime";
					break;
				case 2:
					$select="DATE_FORMAT(c.publish_up,'%H:%i') as cdatetime, DATE_FORMAT(c.publish_up,'%d-%m-%Y') as cdate";
					break;
				case 3:
					$select="DATE_FORMAT(c.publish_up,'%d-%m-%Y') as cdate";
					break;
			}
		} else $select="c.publish_up as created, 
		c.introtext, c.fulltext, c.modified, s.title as stitle, c.alias as slug, cat.alias as catslug, 
		cat.title as cattitle, a.".$config->username_t." as author, c.created_by_alias, c.attribs, CHAR_LENGTH( c.fulltext ) as readmore ";
	
		$query = "SELECT c.title, ".$select." , c.id, c.catid, c.sectionid
			FROM #__content as c 
			INNER JOIN #__users as a ON a.id = c.created_by 
			LEFT JOIN #__sections as s ON s.id = c.sectionid 
			LEFT JOIN #__categories as cat ON cat.id = c.catid 	
			WHERE ((c.publish_down='0000-00-00 00:00:00' OR c.publish_down>=NOW()) 
			AND c.state=1 AND c.access<=".$user->aid." AND ((s.published = 1 AND cat.published = 1 AND s.access<=".$user->aid." AND cat.access<=".$user->aid." AND c.sectionid<>0) ".$uncat."))  
			AND ".$where."  
			ORDER BY c.publish_up DESC ";

		$this->_db->setQuery( $query,  $limitstart, $count);
		$alist=$this->_db->loadObjectList();
	
		return $alist;
	}

	function getpage($alist_d,$alist,$config,$pag)
    {

		$content='';
		for ($i=0;$i<count($alist);$i++)
		{
		
			if ($config->pldate>1 && $alist[$i]->cdate!=$alist[$i-1]->cdate)
			{
				$content=$content.'<div id="jalendar_ds2">'.$alist[$i]->cdate.'</div><br>';
			}
			if ($config->pldate<3) 
			{
				$content=$content.'<span id="jalendar_ds">'.$alist[$i]->cdatetime.' </span> ';
			}
			$content=$content.'<a href="index.php?option=com_content&view=article&id='.$alist[$i]->id.'">'.$alist[$i]->title.'</a><br><br>';
	
		}	
		
		if (count($alist_d) && count($alist)) $content=$content.'<hr size=1 width=100% color=black>';
		
		for ($i=0;$i<count($alist_d);$i++)
		{
		
			if ($config->pldate>1 && $alist_d[$i]->cdate!=$alist_d[$i-1]->cdate)
			{
				$content=$content.'<div id="jalendar_ds2">'.$alist_d[$i]->cdate.'</div><br>';
			}
			if ($config->pldate<3) 
			{
				$content=$content.'<span id="jalendar_ds">'.$alist_d[$i]->cdatetime.' </span> ';
			}
			$content=$content.'<a href="index.php?option=com_content&view=article&id='.$alist_d[$i]->id.'">'.$alist_d[$i]->title.'</a><br><br>';
	
		}	
		$content=$content.'<div align="center">'.$pag->getPagesLinks().'<br>';
		$content=$content.$pag->getPagesCounter().'</div>';
		return $content;
	}
	

	function cwhere($day,$month,$year,$config)
    {

		if (!empty($year)) $where=" YEAR(c.publish_up)=".$year."";
		if (!empty($month)) $where=$where." AND MONTH(c.publish_up)=".$month."";
		if (!empty($day)) $where=$where." AND DAYOFMONTH(c.publish_up)=".$day."";

		if (!empty($config->id_section)) 
		{
			$id_section="('".str_replace(",","','",$config->id_section)."')";
			$where=$where." AND c.sectionid IN ".$id_section." ";
		}
	

		if (!empty($config->id_category)) 
		{
			$id_category="('".str_replace(",","','",$config->id_category)."')";
			$where=$where." AND c.catid IN ".$id_category." ";
		}
	
		if (!empty($config->id_article)) 
		{
			$id_article="('".str_replace(",","','",$config->id_article)."')";
			$where=$where." AND c.id NOT IN ".$id_article." ";
		}
	
		return $where;
	}	

	function cwhere2($day,$month,$year,$config)
    {
		if (!empty($year)) $where="((YEAR(j.date)=".$year." AND j.type=0) OR j.type=1)";
		if (!empty($month)) $where=$where." AND MONTH(j.date)=".$month."";
		if (!empty($day)) $where=$where." AND DAYOFMONTH(j.date)=".$day."";	
		return $where;
	}	
	
}
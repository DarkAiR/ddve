<?php
/**
* @Copyright Copyright (C) 2010- BMForce
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
class modJalendar
{

	function getCSS($params)
    {
		$css='.yearname{font-family: "Trebuchet MS", Arial, sans-serif; font-size: '.$params->get('year_size').'pt;font-weight: bolder;color:'.$params->get('color_year').';} ';
		$css=$css.'.monthname {font-family: "Trebuchet MS", Arial, sans-serif;font-size: '.$params->get('month_size').'pt;font-weight: bolder;color:'.$params->get('color_month').';} ';
		if ($params->get('month_link')) $css=$css.'a.monthlink{color: '.$params->get('color_month').' !important;text-decoration: '.$params->get('underline_month').' !important;}' ;
		if ($params->get('year_link')) $css=$css.'a.yearlink{color: '.$params->get('color_year').' !important;text-decoration: '.$params->get('underline_year').' !important;} ';

		$css=$css.'table.grid_c {font-family: "Trebuchet MS", Arial, sans-serif;font-size: 10pt;}';
		$css=$css.'td#dayname {font-weight: bolder;}';
		$css=$css.'td.pndayweek {color: '.$params->get('color_pnmonthday').';}';
		$css=$css.'td.numweek{color: '.$params->get('color_num').';}';
		$css=$css.'a.dwlink{color: '.($params->get('color_daylink')?$params->get('color_daylink'):('inherit')).' !important;text-decoration: '.$params->get('underline_day').' !important;}';

		for($i = 1; $i <= 7; $i++)
		{
			$css=$css.'td.dayweek'.$i.' {color: '.$params->get('color_'.$i).';}';
		}
		return $css;

    }

	function horiz($calen,$params,$links,$curmonth,$curyear,$numweek)
    {
		$fday=$params->get( "firstday" );

		$content='';
		for($i = 0; $i < count($calen); $i++)
		{
			$content=$content."<tr align='center'>";
			if ($params->get( "num_week" )==1) $content=$content."<td class='numweek'>".($i+1)."</td>";
			elseif($params->get( "num_week" )==2) $content=$content."<td class='numweek'>".($numweek+$i)."</td>";
	
			for($j=0; $j < 7; $j++)
			{
				if(!empty($calen[$i][$j]))
				{
					$pcn=explode(' ',$calen[$i][$j]);
					if ($pcn[1]) $content=$content."<td class='pndayweek'>".$pcn[0]."</td>";
					elseif ($params->get( "all_links" )==2 || ($params->get( "all_links" )==1 && (count($links)>0 && in_array(date('Y-m-d', mktime(1, 1, 1, $curmonth, $pcn[0], $curyear)),$links)))) 
					{
						$jr='index.php?option=com_jalendar&view=articles&year='.$curyear.'&month='.$curmonth.'&day='.$pcn[0];
						$content=$content."<td class='dayweek".((($j+$fday)>6)?(($j+$fday)-6):($j+$fday+1))."'><a class='dwlink' href='".$jr."'>".$pcn[0]."</a></td>";
					}
					else $content=$content."<td class='dayweek".((($j+$fday)>6)?(($j+$fday)-6):($j+$fday+1))."'>".$pcn[0]."</td>";
				}
				else $content=$content."<td>&nbsp;</td>";
			}
			$content=$content."</tr>";
		} 
	
		return $content;
    }
	
	function vertic($calen,$params,$links,$curmonth,$curyear,$ajaxed)
    {
		$fday=$params->get( "firstday" );

		$content='';
		for($j=0; $j < 7; $j++)
		{
			$content=$content."<tr align='center'>";
			$content=$content."<td class='dayweek".(($j>6-$fday)?($j-6+$fday):($j+1+$fday))."' id='dayname'>".modJalendar::get_en($params->get( "dayname_len" ).'dn'.(($j>6-$fday)?($j-6+$fday):($j+1+$fday)),$encode,$ajaxed)."</td>";
	
			for($i = 0; $i < count($calen); $i++)
			{
				if(!empty($calen[$i][$j]))
				{
					$pcn=explode(' ',$calen[$i][$j]);
					if ($pcn[1]) $content=$content."<td class='pndayweek'>".$pcn[0]."</td>";
					elseif ($params->get( "all_links" )==2 || ($params->get( "all_links" )==1 && (count($links)>0 && in_array(date('Y-m-d', mktime(1, 1, 1, $curmonth, $pcn[0], $curyear)),$links)))) 
					{
						$jr='index.php?option=com_jalendar&view=articles&year='.$curyear.'&month='.$curmonth.'&day='.$pcn[0];
						$content=$content."<td class='dayweek".((($j+$fday)>6)?(($j+$fday)-6):($j+$fday+1))."'><a class='dwlink' href='".$jr."'>".$pcn[0]."</a></td>";
					}
					else $content=$content."<td class='dayweek".((($j+$fday)>6)?(($j+$fday)-6):($j+$fday+1))."'>".$pcn[0]."</td>";
				}
				else $content=$content."<td>&nbsp;</td>";
			}
			$content=$content."</tr>";
		} 
		return $content;
    }

	function get_en($text,$encode,$ajaxed)
    {
		if ($encode!='UTF-8' && $ajaxed)
		$text=iconv("UTF-8", $encode, JText::_($text));
		else $text=JText::_($text);
		return $text;
    }
 
    function getCal($curmonth,$curyear,$params,$dayofmonths)
    {
		$dayofmonth = $dayofmonths[$curmonth-1];
		$day_count = 1;
		$num = 0;


		for($i = 0; $i < 7; $i++)
		{

			$a=floor((14-$curmonth)/12);
			$y=$curyear-$a;
			$m=$curmonth+12*$a-2;
			$dayofweek=($day_count+$y+floor($y/4)-floor($y/100)+floor($y/400)+floor((31*$m)/12)) % 7;
			$dayofweek = $dayofweek - 1 - $params->get("firstday");
			if($dayofweek <= -1) $dayofweek =$dayofweek + 7;


			if($dayofweek == $i)
			{
				$week[$num][$i] = $day_count.' 0';
				$day_count++;
			}
			elseif ($params->get("pnmonths"))
			{
				$week[$num][$i] = ($dayofmonths[$curmonth!=1?($curmonth-2):(11)]-($dayofweek-1-$i)).' 1';
			}
		}

		while(true)
		{
			$num++;
			for($i = 0; $i < 7; $i++)
			{
				if($day_count > $dayofmonth && $params->get("pnmonths")) $week[$num][$i] = ($day_count-$dayofmonths[$curmonth-1]).' 1';
				elseif ($day_count <= $dayofmonth) $week[$num][$i] = $day_count.' 0';
				$day_count++;
	  
				if($day_count > $dayofmonth && $i==6) break;
			}
			if($day_count > $dayofmonth && $i==6) break;
		}
		return $week;
    }
	


	function DayLinkC($curmonth,$curyear)
    {

		$user = &JFactory::getUser();

		$start_month = date('Y-m-01', mktime(1, 1, 1, $curmonth, 1, $curyear));
		$end_month = date('Y-m-t', mktime(1, 1, 1, $curmonth, 1, $curyear));
		
		$where=" ((j.date BETWEEN '".$start_month."' AND '".$end_month."') AND j.type=0) OR (j.type=1 AND MONTH(j.date)='".$curmonth."')";
		
		
		$db = &JFactory::getDBO(); 
		$query = "SELECT IF (j.type<>0,DATE_FORMAT(j.date,'".$curyear."-%m-%d'),j.date) 
			FROM #__jalendar as j 
			INNER JOIN #__content as c ON j.id_article = c.id 
			INNER JOIN #__sections as s ON s.id = c.sectionid 
			INNER JOIN #__categories as cat ON cat.id = c.catid 		
			WHERE ((c.publish_down='0000-00-00 00:00:00' OR c.publish_down>=NOW()) 
			AND c.state=1 AND c.access<=".$user->aid." AND ((s.published = 1 AND cat.published = 1 AND s.access<=".$user->aid." AND cat.access<=".$user->aid." AND c.sectionid<>0) OR (c.sectionid=0))) 
			AND ".$where." ";
		$db->setQuery( $query ); 
		return $db->loadResultArray();  
	}
	
	
	function DayLink( $curmonth,$curyear,$config)
    {
	
		$user = &JFactory::getUser();
		if ($config->uncat) $uncat="OR (c.sectionid=0)";
		$start_month = date('Y-m-01', mktime(1, 1, 1, $curmonth, 1, $curyear));
		$end_month = date('Y-m-t', mktime(1, 1, 1, $curmonth, 1, $curyear));

		$where="DATE(c.publish_up) BETWEEN '".$start_month."' AND '".$end_month."'";
	
		if (!empty($config->id_section)) 
		{
			$id_section="('".str_replace(",","','",$config->id_section)."')";
			$where=$where." AND c.sectionid IN ".$id_section."";
		}
	
		if (!empty($config->id_category)) 
		{
			$id_category="('".str_replace(",","','",$config->id_category)."')";
			$where=$where." AND c.catid IN ".$id_category."";
		}
	
		if (!empty($config->id_article)) 
		{
			$id_article="('".str_replace(",","','",$config->id_article)."')";
			$where=$where." AND c.id NOT IN ".$id_article."";
		}	
		
		$db = &JFactory::getDBO(); 
		$query = "SELECT DATE(c.publish_up) as cdate 
			FROM #__content as c 
			LEFT JOIN #__sections as s ON s.id = c.sectionid 
			LEFT JOIN #__categories as cat ON cat.id = c.catid 	
			WHERE ((c.publish_down='0000-00-00 00:00:00' OR c.publish_down>=NOW()) 
			AND c.state=1 AND c.access<=".$user->aid." AND ((s.published = 1 AND cat.published = 1 AND s.access<=".$user->aid." AND cat.access<=".$user->aid." AND c.sectionid<>0) ".$uncat."))  
			AND ".$where."  
			GROUP BY DATE(c.publish_up)";
			
		$db->setQuery( $query ); 
		return $db->loadResultArray();  
    }
	
	function getContent( $calen,$params,$curmonth,$curyear,$links,$mid,$ajaxed,$dayofmonths,$rooturi)
    {
		GLOBAL $mainid;
		   
		$encode=$params->get( "encode" );
		$monthname=JText::_($params->get( "monthname_len" ).'m'.$curmonth);
		if ($params->get( "arrow_en" )==1) $rs="rowspan='2'";
	

		$nextyear=$curyear+1;
		$prevyear=$curyear-1;
		$nmyear=$curyear;
		$pmyear=$curyear;
		if ($curmonth==12) 
		{
			$nextmonth=1;
			$nmyear=$curyear+1;
		}
		else $nextmonth=$curmonth+1;
		if ($curmonth==1) 
		{
			$prevmonth=12;
			$pmyear=$curyear-1;
		} 
		else $prevmonth=$curmonth-1;


		if ($params->get( "use_ajax" ))
		{
			$yl_arrow='<img src="'.$rooturi.'modules/mod_jalendar/img/l2.png" href="javascript:void(0)" onClick="aj_nd('.$curmonth.','.$prevyear.','.$mid.')" style="cursor:pointer">';
			$ml_arrow='<img src="'.$rooturi.'modules/mod_jalendar/img/l.png" href="javascript:void(0)" onClick="aj_nd('.$prevmonth.','.$pmyear.','.$mid.')" style="cursor:pointer">';
			$mr_arrow='<img src="'.$rooturi.'modules/mod_jalendar/img/r.png" href="javascript:void(0)" onClick="aj_nd('.$nextmonth.','.$nmyear.','.$mid.')" style="cursor:pointer">';
			$yr_arrow='<img src="'.$rooturi.'modules/mod_jalendar/img/r2.png" href="javascript:void(0)" onClick="aj_nd('.$curmonth.','.$nextyear.','.$mid.')" style="cursor:pointer">';
		}
		else
		{
			$yl_arrow='<a href="index.php?curmonth='.$curmonth.'&curyear='.$prevyear.'"><img src="'.$rooturi.'modules/mod_jalendar/img/l2.png"></a>';
			$ml_arrow='<a href="index.php?curmonth='.$prevmonth.'&curyear='.$pmyear.'"><img src="'.$rooturi.'modules/mod_jalendar/img/l.png"></a>';
			$mr_arrow='<a href="index.php?curmonth='.$nextmonth.'&curyear='.$nmyear.'"><img src="'.$rooturi.'modules/mod_jalendar/img/r.png"></a>';
			$yr_arrow='<a href="index.php?curmonth='.$curmonth.'&curyear='.$nextyear.'"><img src="'.$rooturi.'modules/mod_jalendar/img/r2.png"></a>';
		}

		$content= "<DIV align='center' id='idcal'>";
		$content=$content."<table width='100%' class='jal_header'>";
		$content=$content."<tr>";
		$content=$content."<td align='right' ".$rs.">";
		if ($params->get( "arrow_en" )>1)  $content=$content.$yl_arrow;
		if ((!$params->get( "linecount" ) && $params->get( "arrow_en" )!=0) || ($params->get( "linecount" ) && $params->get( "arrow_en" )==1)) $content=$content.$ml_arrow;
		$content=$content."</td>";
		$content=$content."<td align='center' valign='top' class='yearname'>";
 
		if ($params->get( "linecount" )) 
		{
			if ($params->get( "year_link" ))  $content=$content.'<a class="yearlink" href="index.php?option=com_jalendar&view=articles&Itemid='.$mainid.'&year='.$curyear.'">';
			$content=$content.$curyear;
			if ($params->get( "year_link" ))  $content=$content.'</a>';
		}
		else 
		{
			if ($params->get( "month_link" ))  $content=$content.'<a class="monthlink" href="index.php?option=com_jalendar&view=articles&Itemid='.$mainid.'&year='.$curyear.'&month='.$curmonth.'">';
			$content=$content.modJalendar::get_en($monthname,$encode,$ajaxed);
			if ($params->get( "month_link" ) && $params->get( "year_link" )) $content=$content.'</a>';
			$content=$content.' ';
			if ($params->get( "year_link" ))  $content=$content.'<a href="index.php?option=com_jalendar&view=articles&Itemid='.$mainid.'&year='.$curyear.'">';
			$content=$content.$curyear; 
			if ($params->get( "year_link" ) || (!$params->get( "year_link" ) && $params->get( "month_link" ))) $content=$content.'</a>';
		}
 
		$content=$content."</td>";
  
		$content=$content."<td align='left' ".$rs.">";
		if ((!$params->get( "linecount" ) && $params->get( "arrow_en" )!=0) || ($params->get( "linecount" ) && $params->get( "arrow_en" )==1)) $content=$content.$mr_arrow;
		if ($params->get( "arrow_en" )>1) $content=$content.$yr_arrow;
		$content=$content."</td>";
		$content=$content."</tr>";
  
		if ($params->get( "linecount" ))
		{
			$content=$content."<tr>";
			if ($params->get( "arrow_en" )!=1)    $content=$content."<td align='right'>";
			if ($params->get( "arrow_en" )==2) $content=$content.$ml_arrow;
			if ($params->get( "arrow_en" )!=1)  $content=$content."</td>";
			$content=$content."<td align='center' valign='top' class='monthname'>";

			if ($params->get( "month_link" ))  $content=$content.'<a class="monthlink" href="index.php?option=com_jalendar&view=articles&Itemid='.$mainid.'&year='.$curyear.'&month='.$curmonth.'">';
			$content=$content.modJalendar::get_en($monthname,$encode,$ajaxed);
			if ($params->get( "month_link" )) $content=$content.'</a>';

			$content=$content."</td>";
			if ($params->get( "arrow_en" )!=1)      $content=$content."<td align='left'>";
			if ($params->get( "arrow_en" )==2)  $content=$content.$mr_arrow;
			if ($params->get( "arrow_en" )!=1)   $content=$content."</td>";

			$content=$content."</tr>";
		}
		$content=$content."</table>";
		$content=$content."<table align='center' width='100%' class='grid_c'>";

		$content=$content."<tr align='center'>";
 
		if ($params->get( "orientation" ) || $params->get( "num_week" )) $content=$content."<td></td>";
 
		if (!$params->get( "orientation" )) 
		for($i =$params->get( "firstday" ); $i <=$params->get( "firstday" )+6; $i++) 
		$content=$content."<td class='dayweek".(($i>6)?($i-6):($i+1))."' id='dayname'>".modJalendar::get_en($params->get( "dayname_len" ).'dn'.(($i>6)?($i-6):($i+1)),$encode,$ajaxed)."</td>";
	
 
		if ($params->get( "num_week" )) 
		{
			if ($curmonth>1)
			{
				$a=floor((13)/12);
				$y=$curyear-$a;
				$m=12*$a-1;
				$dayofweek=($day_count+$y+floor($y/4)-floor($y/100)+floor($y/400)+floor((31*$m)/12)) % 7;
				$prevdays=array_chunk($dayofmonths, $curmonth-1, true);
				$numweek= ceil((array_sum($prevdays[0])+$dayofweek+1)/7);
			} else $numweek=1;

			if ($params->get( "orientation" )) for($i =0; $i < count($calen); $i++)
			{
				if ($params->get( "num_week" )==1) $content=$content."<td class='numweek'>".($i+1)."</td>";
				elseif($params->get( "num_week" )==2) $content=$content."<td class='numweek'>".($numweek+$i)."</td>";
			}

		}
 


		if (!$params->get( "orientation" )) $content=$content.modJalendar::horiz($calen,$params,$links,$curmonth,$curyear,$numweek);
		else $content=$content.modJalendar::vertic($calen,$params,$links,$curmonth,$curyear,$ajaxed);

		$content=$content."</tr>";


		$content=$content."</table></DIV>";

		return $content;
	}


}
?>
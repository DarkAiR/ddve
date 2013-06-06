<?php
/* * ******************************************************************
  Product    : MiniCalendar
  Author     : Chris Gaebler
  Date       : 20 March 2011
  Copyright  : Les Arbres Design 2010-2011
  Contact    : http://extensions.lesarbresdesign.info
  Licence    : GNU General Public License
  Description: Displays a calendar in a module position
 * ******************************************************************* */

defined( '_JEXEC' ) or die( 'Restricted access' );

//-------------------------------------------------------------------------------
// Define cal_days_in_month() in case server doesn't support it
//
if( !function_exists( 'cal_days_in_month' ) )
{

    function cal_days_in_month( $calendar, $month, $year )
    {
        return date( 't', mktime( 0, 0, 0, $month + 1, 0, $year ) );
    }

}

//---------------------------------------------------------------------------------------------
// Get an array of day names in the current language
// $source is 0 for PHP or 1 for Joomla
//
function get_day_names( $start_day, $source )
{
    if( $source == 0 )
    {
        for( $i = 0; $i < 7; $i++ )
        {
            $day = $i + $start_day;
            $day_time = ($day + 3) * 86400;   // zero time was Thursday 1st of January 1970
            $days[] = gmstrftime( '%A', $day_time ); // use GMT to get the day names
        }
    }
    else
    {
        $j_days = array( "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" );
        for( $i = 0; $i < 7; $i++ )
        {
            $day = ($i + $start_day) % 7;
            $days[] = $j_days[$day];
        }
    }
    return $days;
}

//---------------------------------------------------------------------------------------------
// Get a month name in the current language
// $source is 0 for PHP or 1 for Joomla
//
function get_month_name( $month, $source )
{
    if( $source == 0 )
    {
        $month_time = mktime( 0, 0, 0, $month, 1, 2010 ); // year is irrelevant, we just want the month name
        $month_name = strftime( '%B', $month_time );
        return $month_name;
    }
    else
    {
        switch( $month )
        {
            case 1: return "Январь"; //JText::_('JANUARY');
            case 2: return "Февраль"; //JText::_('FEBRUARY');
            case 3: return "Март"; //JText::_('MARCH');
            case 4: return "Апрель"; //JText::_('APRIL');
            case 5: return "Май"; //JText::_('MAY');
            case 6: return "Июнь"; //JText::_('JUNE');
            case 7: return "Июль"; //JText::_('JULY');
            case 8: return "Август"; //JText::_('AUGUST');
            case 9: return "Сентябрь"; //JText::_('SEPTEMBER');
            case 10: return "Октябрь"; //JText::_('OCTOBER');
            case 11: return "Ноябрь"; //JText::_('NOVEMBER');
            case 12: return "Декабрь"; //JText::_('DECEMBER');
        }
    }
}

//---------------------------------------------------------------------------------------------
// Draw a calendar for one month in any language
// $link is blank for no links, or a url ready to append 'p' for previous or 'n' for next
// $translation is 0 for PHP or 1 for Joomla
//
function make_calendar( $year, $month, $link = '', $encoding, $day_name_length, $start_day, $weekHdr, $translation )
{
    $current_year  = date( 'Y' );
    $current_month = date( 'm' );
    $current_day   = date( 'd' );

    $m = new minicalendarModel();
    $a = $m->getAllArticles(null,$month,$year,36);
    $articles = array();
    foreach( $a as $article )
    {
        $articles[ (int)date("d",strtotime($article->created)) ][] = $article;
    }

    $num_columns = 7;          // without week numbers, we have 7 columns
    if( ($weekHdr != '') and ($start_day == 1) )    // only show week numbers if start day is Monday
        $num_columns = 8;
    else
        $weekHdr = '';          // if start day not Monday, don't do week numbers

    $month_string = get_month_name( $month, $translation );   //.' '.$year;
    if( $encoding )
        $month_string = utf8_encode( $month_string );
    ?>

    <div id="mod_minical">
        <div id="mod_minical_header">
            <div id="mod_minical_left"><a href="<?php echo $link ?>p"></a></div>
            <div id="mod_minical_month"><?php echo $month_string ?></div>
            <div id="mod_minical_right"><a href="<?php echo $link; ?>n"></a></div>
        </div>
        <div id="mod_minical_days">
            <?php show_days( $day_name_length, $start_day, $translation, $encoding ); ?>
        </div>
        <div id="mod_minical_calendar">

            <?php
            //echo "\n".'<table class="mod_minical_table" align="center" cellspacing="0">'."\n";
            //echo "\n<tr>";
// draw the month and year heading in the current language
            //echo '<th colspan="'.$num_columns.'">';
            //if ($link != '')
            //	echo '<a href="'.$link.'p"><span class="mod_minical_left"></span></a><span class="mod_minical_month">';
            //if ($link != '')
            //	echo '</span><a href="'.$link.'n"><span class="mod_minical_right"></span></a>';
            //echo '</th>';
            //echo '</tr>';
            // ... days
            // DarkAiR
            echo '<table class="mod_minical_table" align="center" cellspacing="0">';


            $day_time = gmmktime( 0, 0, 0, $month, 1, $year );   // GMT of first day of month
            $first_weekday = gmstrftime( "%w", $day_time );  // 0 = Sunday ... 6 = Saturday
            //$weeknumber = gmstrftime("%V",$day_time);			// first week number
            $first_column = ($first_weekday + 7 - $start_day) % 7;  // column for first day
            $days_in_month = cal_days_in_month( CAL_GREGORIAN, $month, $year );
            echo '<tr>';
            //if ($weekHdr != '')
            //	echo '<td class="mod_minical_weekno">'.$weeknumber.'</td>';
            for( $i = 0; $i < $first_column; $i++ )
                echo '<td></td>';
            $column_count = $first_column;

            for( $day = 1; $day <= $days_in_month; $day++ )
            {
                $activeClass = '';
                if( $column_count == 5 || $column_count==6 )
                   $activeClass = ' class="mod_minical_holyday"';
                
                if( $column_count == 7 )
                {
                    echo "</tr>\n<tr>";
                    $column_count = 0;
                    //if ($weekHdr != '')
                    //	{
                    //	$day_time = strtotime(strftime('%Y-%m-%d',$day_time).' + 1 week');
                    //	$weeknumber = gmstrftime("%V",$day_time);	// week number
                    //	echo '<td class="mod_minical_weekno">'.$weeknumber.'</td>';
                    //	}
                }

                $dayHtml = $day;
                if( isset($articles[$day]) )
                {
                    // Убираем теги
                    $articleContent = strip_tags( $articles[$day][0]->introtext, "<br><br/>" );
                    // Заменяем все переносы на <br> и удаляем непечатные символы
                    $articleContent = preg_replace( '/[\x00-\x1f]/', '', str_replace("\n", "<br/>", $articleContent) );
                    $idEl = md5(rand());
                    $dayHtml = "<span id='$idEl' class='min_minical_sel'>".$day."</span>";
                    $dayHtml .= "<script type='text/javascript'>".
                                    "jQuery(function() {".
                                        "jQuery('#{$idEl}').balloon( {contents:'$articleContent'} );".
                                    "});".
                                "</script>";
                }

                if( ($year == $current_year) and ($month == $current_month) and ($day == $current_day) )
                    echo '<td id="mod_minical_today"'.$activeClass.'>'.$dayHtml.'</td>'; // highlight today's date
                else
                    echo '<td'.$activeClass.'>'.$dayHtml.'</td>';
                $column_count++;
            }
            for( $i = $column_count; $i < 7; $i++ )
                echo '<td></td>';
            echo "</tr></table>\n";
            ?>

        </div>
    </div>

    <?php
}

// draw the day names heading in the current language
function show_days( $day_name_length, $start_day, $translation, $encoding )
{
    if( $day_name_length > 0 )
    {
        $days = get_day_names( $start_day, $translation );
        for( $i = 0; $i < 7; $i++ )
        {
            $day_name = $days[$i];
            if( $encoding )
                $day_name = utf8_encode( $day_name );
            if( function_exists( 'mb_substr' ) )
                $day_short_name = mb_substr( $day_name, 0, $day_name_length, 'UTF-8' );
            else
                $day_short_name = substr( $day_name, 0, $day_name_length );
            
            $activeClass = '';
            if( $i==5 || $i==6 )
               $activeClass = ' class="mod_minical_holyday"';
            
            echo "<div id='mod_minical_dayname' $activeClass>$day_short_name</div>";
        }
    }
}


jimport( 'joomla.application.component.model' );

class minicalendarModel extends JModel
{
    function getAllArticles($day,$month,$year,$categoryId)
    {
        $user = &JFactory::getUser();
        $where='('.$this->cwhere($day,$month,$year,$categoryId).')';
    
        $query = "SELECT
            c.title, c.id, c.catid, c.sectionid,
            c.publish_up as created,
            c.introtext, c.fulltext, c.modified,
            s.title as stitle,
            c.alias as slug,
            cat.alias as catslug,
            cat.title as cattitle,
            CHAR_LENGTH( c.fulltext ) as readmore    
            FROM #__content as c
            INNER JOIN #__users as a ON a.id = c.created_by 
            LEFT JOIN #__sections as s ON s.id = c.sectionid 
            LEFT JOIN #__categories as cat ON cat.id = c.catid 
            WHERE ((c.publish_down='0000-00-00 00:00:00' OR c.publish_down>=NOW()) 
            AND c.state=1 AND c.access<=".$user->aid." AND ((s.published = 1 AND cat.published = 1 AND s.access<=".$user->aid." AND cat.access<=".$user->aid." AND c.sectionid<>0))) 
            AND ".$where."
            ORDER BY c.publish_up DESC";
        $this->_db->setQuery( $query );
        $alist = $this->_db->loadObjectList();    
    
        return $alist;
    }

    function cwhere($day,$month,$year,$categoryId=false)
    {

        if (!empty($year))  $where = " YEAR(c.publish_up)=".$year."";
        if (!empty($month)) $where = $where." AND MONTH(c.publish_up)=".$month."";
        if (!empty($day))   $where = $where." AND DAYOFMONTH(c.publish_up)=".$day."";

/*        if (!empty($config->id_section)) 
        {
            $id_section="('".str_replace(",","','",$config->id_section)."')";
            $where=$where." AND c.sectionid IN ".$id_section." ";
        }*/
    
        if (!empty($categoryId)) 
        {
            $id_category="('".str_replace(",","','",$categoryId)."')";
            $where=$where." AND c.catid IN ".$id_category." ";
        }
    
        /*if (!empty($config->id_article)) 
        {
            $id_article="('".str_replace(",","','",$config->id_article)."')";
            $where=$where." AND c.id NOT IN ".$id_article." ";
        }*/
    
        return $where;
    }   
}


<?php

/* * ******************************************************************
  Product    : MiniCalendar
  Author     : Chris Gaebler
  Date       : 15 March 2011
  Version    : 2.04
  Copyright  : Les Arbres Design 2010-2011
  Contact    : http://extensions.lesarbresdesign.info
  Licence    : GNU General Public License
  Description: Displays a calendar in a module position
 * ******************************************************************* */

defined( '_JEXEC' ) or die( 'Restricted access' );

require_once (dirname( __FILE__ ) . DS . 'helper.php');

if( $params->get('type') == 0 )
    JHTML::stylesheet( 'styles.css', 'modules/mod_minicalendar/' );
else
    JHTML::stylesheet( 'styles_mini.css', 'modules/mod_minicalendar/' );

JHTML::script( 'jquery.balloon.min.js', 'modules/mod_minicalendar/' );

// Get module parameters

$startyear          = trim( $params->get( 'startyear' ) );
$startmonth         = trim( $params->get( 'startmonth' ) );
$numMonths          = trim( $params->get( 'numMonths', 1 ) );
$numCols            = trim( $params->get( 'numCols', 1 ) );
$links              = $params->get( 'links', 0 );
$translation        = $params->get( 'translation', 1 );
$locale             = trim( $params->get( 'locale' ) );
$timeZone           = $params->get( 'timeZone', 0 );
$encoding           = $params->get( 'encoding', -1 );
$day_name_length    = trim( $params->get( 'dayLength', 1 ) ); // length of the day names
$start_day          = trim( $params->get( 'firstDay', 0 ) ); // 0 for Sunday, 1 for Monday, etc
$weekHdr            = trim( $params->get( 'weekHdr' ) );

// If any internal styles are defined, add them to the document head

if( $locale != '' )
    setlocale( LC_TIME, $locale );

if( $encoding == "-1" )     // auto-detect if UTF-8 encoding required
{
    $locale = setlocale( LC_TIME, 0 );  // get the current locale
    if( (stristr( $locale, "UTF" )) and (strstr( $locale, "8" )) )
        $encoding = 0;     // locale is UTF-8, encoding not required
    else
        $encoding = 1;     // locale is not UTF-8, encoding is required
}

if( ($timeZone != '0') and (function_exists( 'date_default_timezone_set' )) )
    date_default_timezone_set( $timeZone );

// if links are in use, create the link address and get our month offsetting parameter
// our parameter is &cal_offset=nnx 
// where nn is the current offset and x is 'p' for the previous month or 'n' for the next month

$link = '';
$current_offset = 0;
if( $links )
{
    $uri = $_SERVER['REQUEST_URI'];

    $prms = array(); 
    $link = $uri;
    $command = '';
    $current_offset = 0;

    $query = parse_url($uri,PHP_URL_QUERY);
    if (!empty($query))
    {
        $queryParts = explode('&', $query); 
    
        foreach ($queryParts as $prm)
        { 
            $item = explode('=', $prm);
            $prms[$item[0]] = $item[1]; 
        }
        if (isset($prms['cal_offset']))
        {
            $cal_offset = $prms['cal_offset'];
            unset($prms['cal_offset']);
            $len = strlen( $cal_offset );
            $command = $cal_offset{$len - 1};     // get the p or the n
            $current_offset = substr( $cal_offset, 0, $len - 1 ); // strip off the p or the n
            if( $command == 'p' )
                $current_offset -= 1;      // request the previous month
            if( $command == 'n' )
                $current_offset += 1;      // request the next month
        }
    }
    $prms['cal_offset'] = $current_offset;
    $link = parse_url($uri, PHP_URL_PATH) . (count($prms) == 0 ? '' : '?' . http_build_query($prms));
    $link = htmlspecialchars( $link );
}

// Set the initial month and year, defaulting to the current month

if( $startyear )
    $year = $startyear;
else
    $year = date( 'Y' );

if( $startmonth )
    $month = $startmonth;
else
    $month = date( 'm' );

// Add in the current offset

$startdate = mktime( 0, 0, 0, $month + $current_offset, 1, $year );
$month = date( 'm', $startdate );
$year = date( 'Y', $startdate );

// Draw the number of calendars requested in the module parameters

echo '<table align="center"><tr valign="top">';
$colcount = 0;
for( $monthcount = 1; $monthcount <= $numMonths; $monthcount++ )
{
    $colcount++;
    echo '<td>';
    echo make_calendar( $year, $month, $link, $encoding, $day_name_length, $start_day, $weekHdr, $translation );
    $link = '';      // only draw links on first calendar
    echo '</td>';
    if( ($colcount == $numCols) && ($monthcount < $numMonths) )
    {
        echo '</tr><tr valign="top"><td colspan="2"><div class="mod_minical_div"></div></td></tr><tr valign="top">';
        $colcount = 0;
    }
    $month++;
    if( $month > 12 )
    {
        $month = 1;
        $year++;
    }
}
echo '</tr></table>';
?>

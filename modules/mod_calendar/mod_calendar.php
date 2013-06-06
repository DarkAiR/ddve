<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
?>

<div id="days">
    <div id="d1" class="day" onmouseover="mouseOver(1)" onmouseout="mouseOut()"><a href="javascript:void(0)" title="<?php echo $params->get( 'ponedelnik' ); ?>">ПН</a></div>
    <div id="d2" class="day" onmouseover="mouseOver(2)" onmouseout="mouseOut()"><a href="javascript:void(0)" title="<?php echo $params->get( 'vtornik' ); ?>">ВТ</a></div>
    <div id="d3" class="day" onmouseover="mouseOver(3)" onmouseout="mouseOut()"><a href="javascript:void(0)" title="<?php echo $params->get( 'sreda' ); ?>">СР</a></div>
    <div id="d4" class="day" onmouseover="mouseOver(4)" onmouseout="mouseOut()"><a href="javascript:void(0)" title="<?php echo $params->get( 'chetverg' ); ?>">ЧТ</a></div>
    <div id="d5" class="day" onmouseover="mouseOver(5)" onmouseout="mouseOut()"><a href="javascript:void(0)" title="<?php echo $params->get( 'pyatnica' ); ?>">ПТ</a></div>
    <div id="d6" class="day" onmouseover="mouseOver(6)" onmouseout="mouseOut()"><a href="javascript:void(0)" title="<?php echo $params->get( 'subbota' ); ?>">СБ</a></div>
    <div id="d7" class="day" onmouseover="mouseOver(0)" onmouseout="mouseOut()"><a href="javascript:void(0)" title="<?php echo $params->get( 'voskresene' ); ?>">ВС</a></div>
</div>
<div id="time">
    
</div>

<script>
    var calendarDays = new Array();
    calendarDays[0] = '<?php echo $params->get( 'voskresene' ); ?>';
    calendarDays[1] = '<?php echo $params->get( 'ponedelnik' ); ?>';
    calendarDays[2] = '<?php echo $params->get( 'vtornik' ); ?>';
    calendarDays[3] = '<?php echo $params->get( 'sreda' ); ?>';
    calendarDays[4] = '<?php echo $params->get( 'chetverg' ); ?>';
    calendarDays[5] = '<?php echo $params->get( 'pyatnica' ); ?>';
    calendarDays[6] = '<?php echo $params->get( 'subbota' ); ?>';

    var calendarId = new Array();
    calendarId[0] = '.moduletable_calendar #days #d7 a';
    calendarId[1] = '.moduletable_calendar #days #d1 a';
    calendarId[2] = '.moduletable_calendar #days #d2 a';
    calendarId[3] = '.moduletable_calendar #days #d3 a';
    calendarId[4] = '.moduletable_calendar #days #d4 a';
    calendarId[5] = '.moduletable_calendar #days #d5 a';
    calendarId[6] = '.moduletable_calendar #days #d6 a';
    
    for( var i=0; i<7; i++ )
        jQuery( calendarId[i] ).css( 'cursor', 'pointer !important' );
    mouseOut();
    
    function mouseOver( day )
    {
        return;
        showCalendarInfo( day );
        selectCalendarDay( day );
    }
    function mouseOut()
    {
        var date = new Date();
        showCalendarInfo( date.getDay() );
        selectCalendarDay( date.getDay() );
    }
    function showCalendarInfo( day )
    {
        jQuery('.moduletable_calendar #time').empty().append( calendarDays[day] );
    }
    function selectCalendarDay( day )
    {
        for( var i=0; i<7; i++ )
            jQuery( calendarId[i] ).removeClass( 'active' );
        jQuery( calendarId[day] ).addClass( 'active' );
        
        var date = new Date();
        jQuery( calendarId[date.getDay()] ).addClass( 'active' );
    }
        
</script>

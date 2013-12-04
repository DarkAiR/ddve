<?php
// no direct access
 defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<script src="templates/<?php echo $this->template ?>/js/jquery-1.6.2.js" type="text/javascript"></script>
<script src="templates/<?php echo $this->template ?>/js/jquery.cookie.js" type="text/javascript"></script>
<script type="text/javascript">
    $.noConflict();
</script>
<jdoc:include type="head" />
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/menu.css" type="text/css" />
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/content.css" type="text/css" />
<link rel="stylesheet" href="templates/system/css/custom_editor.css" type="text/css" />

<script src="templates/<?php echo $this->template ?>/js/swfobject.js" type="text/javascript"></script>
<script src="templates/<?php echo $this->template ?>/js/jquery.scrollTo.js" type="text/javascript"></script>
<script src="templates/<?php echo $this->template ?>/js/jconfirm/jquery.alerts.js" type="text/javascript"></script>
<link href="templates/<?php echo $this->template ?>/js/jconfirm/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />

<script type="text/javascript">
    var console = console || { log:function(){} };
    
    jQuery(document).ready( function()
    {
        // Грязный хак
        // Скрываем пункт меню по умолчанию
        jQuery('.item64').css( 'display', 'none' );

        // Подсвечиваем выбранную категорию
        var categoryId = getCategoryId();
        if( categoryId != 0 )
            jQuery('#categoryItem'+categoryId).addClass('active');

        // Выставляем фон
        var bgArr = {
            '19':'bg_roll',
            '12':'bg_soup',
            '11':'bg_salat',
            '6' :'bg_pizza',
            '8' :'bg_vok',
            '18':'bg_lapsha',
            '14':'bg_desert',
            '13':'bg_drink'
        };
        var bgClass = bgArr[ categoryId ];
        if( bgClass == undefined )
            bgClass = 'bg_roll';
        jQuery('html').addClass( bgClass );

        // Выравниваем страницу по центру
        var wnd = jQuery(window);
        var offs = (1280-wnd.width())/2;
        document.documentElement.scrollLeft = offs;
        document.body.scrollLeft = offs;
        var e = jQuery('html, body');
        e.animate({'scrollLeft': offs});

        // Загружаем банер
        // Выравниваем логотип, банер и календарь
        params = {wmode:"transparent"};
        swfobject.embedSWF( 'images/banners/banner.swf', 'banner', '550', '400', '9.0.0', 'images/banners/banner.swf', '', params, '', setHeaderPosition );
        //jQuery('#header #banner').append( '<div style="width:450px; height:140px; display:block; text-align:center; position:relative; top:-40px;"><img src="images/banners/banner.gif" width="357px" height="210px"/></div>' );
        setHeaderPosition();
        
        // Копируем верхнее меню в левое
        copyTopMenuToLeftMenu();
        
        return;
        
        // Изменяем шаблон вывода и функцию обработки меню
        jQuery('[id^="category"] a').live( 'click', function( e )
        {
            e.preventDefault();
            var self = jQuery(this);
            var url = self.attr('href');
            jQuery.get( url + '&format=raw', function( data )
            //jQuery.get( url, function( data )
            {
                document.getElementById('main').innerHTML = data;
                copyTopMenuToLeftMenu();
                
                // Эмулируем другой URL
                window.history.pushState( null, null, url );
                
                // Поменяем подсветку на пунктах
                jQuery( '#left .active' ).removeClass( 'active' );
                self.addClass( 'active' );
            });
        });

        // Обработка кнопки "Назад"
        var popped = ('state' in window.history), initialURL = location.href;
        window.addEventListener("popstate", function(e)
        {
            // Ignore inital popstate that some browsers fire on page load
            var initialPop = !popped && location.href == initialURL;
            popped = true;
            if( initialPop )
                return;
  
            jQuery.get( location.href + '&format=raw', function( data )
            {
                document.getElementById('main').innerHTML = data;
            });
        }, false );
    });

    jQuery(window).resize( function()
    {
        setHeaderPosition();
    });

    function setHeaderPosition()
    {
        var left = jQuery('#header').offset().left;

        var logo = jQuery('#header #logo');
        logo.css( 'left', left + 190 );

        var banner = jQuery('#header #banner');
        banner.css( 'left', left + 420 - 30 );

        var calendar = jQuery('#header #calendar');
        calendar.css( 'left', left + 940 );
    }

    function copyTopMenuToLeftMenu()
    {
        // Копируем элементы в меню
        var topMenu = jQuery( '#main div[id^="topmenu_"]' );
        
        var topMenuChildren = topMenu.children();
        if( topMenuChildren.length == 0 )
        {
            // Верхнего меню нет, удалим старое, если есть
            jQuery('#left div[id^="topmenu_"]').remove();
            return;
        }
        
        if( topMenu.length > 0 )
        {
            var pid = topMenu.attr('id');
            pos = pid.indexOf('_');
            if( pos != -1 )
                pid = pid.slice(pos+1);
                
            if( jQuery('#left div#topmenu_'+pid).length == 0 )
            {
                // Еще ни одно меню не добавлено
                jQuery('li#categoryItem'+pid).append( topMenu );
                topMenu.show( 'slow' );
            }
        }
    }
    
    function getCategoryId()
    {
        return <?php echo isset( $_GET['pcat_id'] )? $_GET['pcat_id'] :
            (isset( $_GET['category_id'] )? $_GET['categiry_id'] : 0); ?>;      
    }
</script>
</head>

<body>

<?php include_once("analyticstracking.php"); ?>
<?php include_once("yandexmetrika.php"); ?>

<div id="page">

    <!--блок шапки сайта header -->
    <div id="header">
        <a id="logo" href="index.php"></a>
        <div id="banner"></div>
        <div id="calendar"><jdoc:include type="modules" name="user2" style="xhtml" /></div>
        <div id="top_line">
            <jdoc:include type="modules" name="top" style="xhtml" />
            <jdoc:include type="modules" name="right" style="xhtml" />
        </div>
    </div>

    <!-- Корзина -->
    <div style="float:left;">
        <jdoc:include type="modules" name="user4" style="xhtml" />
    </div>

    <!--блок контента-->
        <div class="content">

        <table class="content" id='js-content' width="100%" height="100%" cellpadding="0" cellspacing="0">
            <tr>
                <!--левое меню-->
                <td id="left">
                    <jdoc:include type="modules" name="left" style="xhtml" />
                    <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?49"></script>
                    <!-- VK Widget -->
                    <div id="vk_groups"></div>
                    <script type="text/javascript">
                        VK.Widgets.Group("vk_groups", {mode: 1, width: "150", height: "120"}, 37435683);
                    </script>
                </td>
                <!--основной текст-->
                <td id="main">
                    <br/>
                    <jdoc:include type="modules" name="breadcrumb" style="xhtml" />
                    <jdoc:include type="component" style="xhtml" />
                </td>
            </tr>
        </table>

        <!--вывод сведений модуля с информацией об авторских правах в позиции footer -->
        <div id="footer">
            <jdoc:include type="modules" name="footer" style="xhtml" />
        </div>
    </div>

    <div id='seo-block'>
        <?php
            // Оторажаем SEO текст в зависимости от страниц
            $categoryId = isset($_GET['category_id']) ? $_GET['category_id'] : false;
            switch($categoryId)
            {
                // Пицца
                case 6:
                    ?><jdoc:include type="modules" name="seo_footer_text_footer_pizza" style="xhtml" /><?php
                    break;
                // Роллы
                case 19:
                case 20:
                    ?><jdoc:include type="modules" name="seo_footer_text_footer_rolly" style="xhtml" /><?php
                    break;
                // Суши
                case 21:
                    ?><jdoc:include type="modules" name="seo_footer_text_footer_suchi" style="xhtml" /><?php
                    break;
            }
        ?>
    </div>

  </body>
</html>
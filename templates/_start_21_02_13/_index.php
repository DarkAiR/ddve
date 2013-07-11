<?php
// no direct access
 defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/menu.css" type="text/css" />

<script src="templates/<?php echo $this->template ?>/js/jquery-1.6.2.js" type="text/javascript"></script>
<script src="templates/<?php echo $this->template ?>/js/jconfirm/jquery.alerts.js" type="text/javascript"></script>
<link href="templates/<?php echo $this->template ?>/js/jconfirm/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript">
    var console = console || { log:function(){} };

    jQuery(document).ready(
        function()
        {
            // Грязный хак
            // Скрываем пункт меню по умолчанию
            jQuery('.item1').css( 'display', 'none' );

            // Кэшируем
            img22_over = new Image();
            img22_over.src = "templates/<?php echo $this->template ?>/images/img_03_open.jpg";
            //img22_over.onclick = change;
            img31_over = new Image();
            img31_over.src = "templates/<?php echo $this->template ?>/images/img_05_open.jpg";
            img32_over = new Image();
            img32_over.src = "templates/<?php echo $this->template ?>/images/img_06_open.jpg";
            img33_over = new Image();
            img33_over.src = "templates/<?php echo $this->template ?>/images/img_07_open.jpg";

            imgArr = new Array();
            imgArr[22] = "url(templates/<?php echo $this->template ?>/images/img_03_open.jpg)";
            imgArr[31] = "url(templates/<?php echo $this->template ?>/images/img_05_open.jpg)";
            imgArr[32] = "url(templates/<?php echo $this->template ?>/images/img_06_open.jpg)";
            imgArr[33] = "url(templates/<?php echo $this->template ?>/images/img_07_open.jpg)";

            itemsArr = new Array();
            itemsArr[0] = "url(templates/<?php echo $this->template ?>/images/soup1.png)";
            itemsArr[1] = "url(templates/<?php echo $this->template ?>/images/salaty1.png)";
            itemsArr[2] = "url(templates/<?php echo $this->template ?>/images/rolly1.png)";
            itemsArr[3] = "url(templates/<?php echo $this->template ?>/images/lapsha1.png)";
            itemsArr[4] = "url(templates/<?php echo $this->template ?>/images/pizza1.png)";
            itemsArr[5] = "url(templates/<?php echo $this->template ?>/images/vok1.png)";
            itemsArr[6] = "url(templates/<?php echo $this->template ?>/images/deserty1.png)";
            itemsArr[10] = "url(templates/<?php echo $this->template ?>/images/soup2.png)";
            itemsArr[11] = "url(templates/<?php echo $this->template ?>/images/salaty2.png)";
            itemsArr[12] = "url(templates/<?php echo $this->template ?>/images/rolly2.png)";
            itemsArr[13] = "url(templates/<?php echo $this->template ?>/images/lapsha2.png)";
            itemsArr[14] = "url(templates/<?php echo $this->template ?>/images/pizza2.png)";
            itemsArr[15] = "url(templates/<?php echo $this->template ?>/images/vok2.png)";
            itemsArr[16] = "url(templates/<?php echo $this->template ?>/images/deserty2.png)";
            switchItem( 'supy',    0 );
            switchItem( 'salaty',  1 );
            switchItem( 'rolly',   2 );
            switchItem( 'lapsha',  3 );
            switchItem( 'pizza',   4 );
            switchItem( 'vok',     5 );
            switchItem( 'deserty', 6 );
            jQuery('#supy').   live('mouseover', function(e) { switchItem( 'supy',    10 ); });
            jQuery('#supy').   live('mouseout',  function(e) { switchItem( 'supy',     0 ); });
            jQuery('#salaty'). live('mouseover', function(e) { switchItem( 'salaty',  11 ); });
            jQuery('#salaty'). live('mouseout',  function(e) { switchItem( 'salaty',   1 ); });
            jQuery('#rolly').  live('mouseover', function(e) { switchItem( 'rolly',   12 ); });
            jQuery('#rolly').  live('mouseout',  function(e) { switchItem( 'rolly',    2 ); });
            jQuery('#lapsha'). live('mouseover', function(e) { switchItem( 'lapsha',  13 ); });
            jQuery('#lapsha'). live('mouseout',  function(e) { switchItem( 'lapsha',   3 ); });
            jQuery('#pizza').  live('mouseover', function(e) { switchItem( 'pizza',   14 ); });
            jQuery('#pizza').  live('mouseout',  function(e) { switchItem( 'pizza',    4 ); });
            jQuery('#vok').    live('mouseover', function(e) { switchItem( 'vok',     15 ); });
            jQuery('#vok').    live('mouseout',  function(e) { switchItem( 'vok',      5 ); });
            jQuery('#deserty').live('mouseover', function(e) { switchItem( 'deserty', 16 ); });
            jQuery('#deserty').live('mouseout',  function(e) { switchItem( 'deserty',  6 ); });

            jQuery('#div2_2_inner').css( 'display', 'none' );

/*            jQuery('#info2').live('click', function(e)
            {
                if (window.getSelection) { window.getSelection().removeAllRanges(); }
                else if (document.selection && document.selection.clear)
                  document.selection.clear();
            });*/
            jQuery('#div2_2').css( 'cursor', 'pointer' );
            jQuery('#div2_2').live('click', function(e)
            {
                //if (window.getSelection) { window.getSelection().removeAllRanges(); }
                //else if (document.selection && document.selection.clear)
                //    document.selection.clear();
                if( !isOpen )
                {
                    change();
                    jQuery('#div2_2').css( 'cursor', 'default' );
                }
            });

            // Выравниваем страницу по центру
            var wnd = jQuery(window);
            var offs = (1400-wnd.width())/2;
            document.documentElement.scrollLeft = offs;
            document.body.scrollLeft = offs;
            var e = jQuery('html, body');
            e.animate({'scrollLeft': offs});

            // Позиционируем логотип
            setHeaderPosition();
        }
    );

    jQuery(window).resize( function()
    {
        setHeaderPosition();
    });

    var isOpen = false;
    function change()
    {
        isOpen = !isOpen;
        switchImage( "div2_2", 22 );
        switchImage( "div3_1", 31 );
        switchImage( "div3_2", 32 );
        switchImage( "div3_3", 33 );
        jQuery('#div2_2_inner').css( 'display', isOpen?'block':'none' );

        setHeaderPosition();
    }

    // Позиционируем логотип
    function setHeaderPosition()
    {
        var left = jQuery('#page').offset().left;
        var logo = jQuery('#page #logo');
        logo.css( 'left', left + 100 );

        jQuery('#page #supy'   ).css( 'left', left + 594 );
        jQuery('#page #salaty' ).css( 'left', left + 717 );
        jQuery('#page #rolly'  ).css( 'left', left + 558 );
        jQuery('#page #lapsha' ).css( 'left', left + 669 );
        jQuery('#page #pizza'  ).css( 'left', left + 719 );
        jQuery('#page #vok'    ).css( 'left', left + 587 );
        jQuery('#page #deserty').css( 'left', left + 728 );
        jQuery('#page #napitki').css( 'left', left + 930 );
        if( isOpen == false )
        {
            jQuery('#page #supy'   ).css( 'display', 'none' );
            jQuery('#page #salaty' ).css( 'display', 'none' );
            jQuery('#page #rolly'  ).css( 'display', 'none' );
            jQuery('#page #lapsha' ).css( 'display', 'none' );
            jQuery('#page #pizza'  ).css( 'display', 'none' );
            jQuery('#page #vok'    ).css( 'display', 'none' );
            jQuery('#page #deserty').css( 'display', 'none' );
            jQuery('#page #napitki').css( 'display', 'none' );
        }
        else
        {
            jQuery('#page #supy'   ).css( 'display', 'inline' );
            jQuery('#page #salaty' ).css( 'display', 'inline' );
            jQuery('#page #rolly'  ).css( 'display', 'inline' );
            jQuery('#page #lapsha' ).css( 'display', 'inline' );
            jQuery('#page #pizza'  ).css( 'display', 'inline' );
            jQuery('#page #vok'    ).css( 'display', 'inline' );
            jQuery('#page #deserty').css( 'display', 'inline' );
            jQuery('#page #napitki').css( 'display', 'inline' );
        }
    }

    function switchImage( divName, index )
    {
        var div = jQuery('#'+divName);
        var tmp = div.css( 'background-image' );
        div.css( 'background-image', imgArr[index] );
        imgArr[index] = tmp;
    }

    function switchItem( divName, index )
    {
        var div = jQuery('#'+divName);
        div.css( 'background-image', itemsArr[index] );
    }
</script>
</head>

<body>

<?php include_once("analyticstracking.php") ?>

<div id="page">

    <a id="logo" href="index.php"></a>

    <a id='supy'    title='Cупы'      href="index.php?option=com_virtuemart&page=shop.browse&category_id=12&pcat_id=12&Itemid=64"></a>
    <a id='salaty'  title='Салаты'    href="index.php?option=com_virtuemart&page=shop.browse&category_id=11&pcat_id=11&Itemid=64"></a>
    <a id='rolly'   title='Роллы'     href="index.php?option=com_virtuemart&page=shop.browse&category_id=19&pcat_id=19&Itemid=64"></a>
    <a id='lapsha'  title='Китайская лапша'  href="index.php?option=com_virtuemart&page=shop.browse&category_id=18&pcat_id=18&Itemid=64"></a>
    <a id='pizza'   title='Пицца'     href="index.php?option=com_virtuemart&page=shop.browse&category_id=6&pcat_id=6&Itemid=64"></a>
    <a id='vok'     title='Вок-меню'  href="index.php?option=com_virtuemart&page=shop.browse&category_id=8&pcat_id=8&Itemid=64"></a>
    <a id='deserty' title='Десерты'   href="index.php?option=com_virtuemart&page=shop.browse&category_id=14&pcat_id=14&Itemid=64"></a>
    <a id='napitki' title='Напитки'   href="index.php?option=com_virtuemart&page=shop.browse&category_id=13&pcat_id=13&Itemid=64"></a>

    <div id="div1"></div>
    <div id="div2">
        <div id="div2_1"></div>
        <div id="div2_2">
            <div id='div2_2_inner'>
                <div id='leftModules'><jdoc:include type="modules" name="leftmainmenu" style="xhtml" /></div>
                <div id="centerModules"></div>
                <div id="rightModules"><jdoc:include type="modules" name="right" style="xhtml" /></div>
            </div>
        </div>
        <div id="div2_3">
            <div id="minicalendar"><jdoc:include type="modules" name="user3" style="xhtml" /></div>
        </div>
    </div>
    <div id="div3">
        <div id="div3_1"></div>
        <div id="div3_2">
            <div id="footer">
                <jdoc:include type="modules" name="footer" style="xhtml" />
            </div>
        </div>
        <div id="div3_3"></div>
    </div>

</div>

</body>
</html>

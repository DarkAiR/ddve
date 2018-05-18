<?php
// no direct access
 defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php require dirname(__FILE__).'/../smartbanner.php'; ?>

<script src="templates/system/js/jquery-1.10.2.js" type="text/javascript"></script>
<jdoc:include type="head" />
<meta http-equiv="Cache-Control" content="no-cache"/>
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/menu.css" type="text/css" />
<link rel="stylesheet" href="templates/catalog/css/common.css" type="text/css" />
<link rel="stylesheet" href="templates/system/css/custom_editor.css" type="text/css" />
<script src="templates/system/js/jconfirm/jquery.alerts.js" type="text/javascript"></script>
<link href="templates/system/js/jconfirm/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />

<script type="text/javascript">
    var console = console || { log:function(){} };

    jQuery(document).ready( function()
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

        jQuery('#supy').    mouseover( function(e) { jQuery(this).hide(); jQuery('#supy2').css('display','inline');    });
        jQuery('#supy2').   mouseout ( function(e) { jQuery(this).hide(); jQuery('#supy').css('display','inline');     });
        jQuery('#salaty').  mouseover( function(e) { jQuery(this).hide(); jQuery('#salaty2').css('display','inline');  });
        jQuery('#salaty2'). mouseout ( function(e) { jQuery(this).hide(); jQuery('#salaty').css('display','inline');   });
        jQuery('#rolly').   mouseover( function(e) { jQuery(this).hide(); jQuery('#rolly2').css('display','inline');   });
        jQuery('#rolly2').  mouseout ( function(e) { jQuery(this).hide(); jQuery('#rolly').css('display','inline');    });
        jQuery('#lapsha').  mouseover( function(e) { jQuery(this).hide(); jQuery('#lapsha2').css('display','inline');  });
        jQuery('#lapsha2'). mouseout ( function(e) { jQuery(this).hide(); jQuery('#lapsha').css('display','inline');   });
        jQuery('#pizza').   mouseover( function(e) { jQuery(this).hide(); jQuery('#pizza2').css('display','inline');   });
        jQuery('#pizza2').  mouseout ( function(e) { jQuery(this).hide(); jQuery('#pizza').css('display','inline');    });
        jQuery('#vok').     mouseover( function(e) { jQuery(this).hide(); jQuery('#vok2').css('display','inline');     });
        jQuery('#vok2').    mouseout ( function(e) { jQuery(this).hide(); jQuery('#vok').css('display','inline');      });
        jQuery('#deserty'). mouseover( function(e) { jQuery(this).hide(); jQuery('#deserty2').css('display','inline'); });
        jQuery('#deserty2').mouseout ( function(e) { jQuery(this).hide(); jQuery('#deserty').css('display','inline');  });

        jQuery('#gift1').hide();
        jQuery('#gift2').hide();
        jQuery('#gift3').hide();
        jQuery('#gift4').hide();
        //jQuery('#giftarea1').on('mouseover', function(e) { jQuery('#gifts').hide(); jQuery('#gift1').show(); });
        //jQuery('#giftarea1').on('mouseout',  function(e) { jQuery('#gifts').show(); jQuery('#gift1').hide(); });
        jQuery('#giftarea2').on('mouseover', function(e) { jQuery('#gifts').hide(); jQuery('#gift2').show(); });
        jQuery('#giftarea2').on('mouseout',  function(e) { jQuery('#gifts').show(); jQuery('#gift2').hide(); });
        jQuery('#giftarea3').on('mouseover', function(e) { jQuery('#gifts').hide(); jQuery('#gift3').show(); });
        jQuery('#giftarea3').on('mouseout',  function(e) { jQuery('#gifts').show(); jQuery('#gift3').hide(); });
        //jQuery('#giftarea4').on('mouseover', function(e) { jQuery('#gifts').hide(); jQuery('#gift4').show(); });
        //jQuery('#giftarea4').on('mouseout',  function(e) { jQuery('#gifts').show(); jQuery('#gift4').hide(); });

        jQuery('#div2_2_inner').css( 'display', 'none' );

/*            jQuery('#info2').on('click', function(e)
        {
            if (window.getSelection) { window.getSelection().removeAllRanges(); }
            else if (document.selection && document.selection.clear)
              document.selection.clear();
        });*/

        jQuery('#div2_2')
            .css( 'cursor', 'pointer' )
            .on('click', function(e)
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


        // Подцепляем балун
        var tipSize = 10;
        jQuery('#div2_2_close')
            .mousemove( function(e)
            {
                var balloonEl = jQuery('.balloonTip');
                var offsLeft = parseInt( balloonEl.css('paddingLeft') );
                var offsTop = parseInt( balloonEl.css('paddingTop') );
                balloonEl.css({'left':e.pageX - balloonEl.width()/2 - offsLeft, 'top':e.pageY - balloonEl.height() - tipSize - offsTop*2 - 5});
            });
        jQuery( function()
        {
            jQuery('#div2_2_close').balloon({
                contents:'Нажми на холодильник',
                minLifetime: 0,
                classname: "balloonTip",
                showDuration: 0,
                hideDuration: 0,
                showAnimation: function(d)
                {
                    this.show();
                    // Вырубаем нафиг обработчик наведения курсора, чтобы быстрые дрыганья, не портили тултип
                    this.unbind('mouseover');
                },
                tipSize: tipSize
            });
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
    });

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
        jQuery('#div2_2_close').css( 'display', isOpen?'none':'block' );

        setHeaderPosition();
    }

    // Позиционируем логотип
    function setHeaderPosition()
    {
        var left = jQuery('#page').offset().left;
        var logo = jQuery('#page #logo');
        logo.css( 'left', left + 100 );

        jQuery('#page #gifts').css( 'left', left + 97 );
        jQuery('#page #gift1').css( 'left', left + 65 );
        jQuery('#page #gift2').css( 'left', left + 97 );
        jQuery('#page #gift3').css( 'left', left + 97 );
        jQuery('#page #gift4').css( 'left', left + 97 );
        jQuery('#page #giftarea1').css( 'left', left + 100 );
        jQuery('#page #giftarea2').css( 'left', left + 182 );
        jQuery('#page #giftarea3').css( 'left', left + 265 );
        jQuery('#page #giftarea4').css( 'left', left + 365 );

        if( isOpen == false )
        {
            jQuery('.supy'    ).css( 'display', 'none' );
            jQuery('.salaty'  ).css( 'display', 'none' );
            jQuery('.rolly'   ).css( 'display', 'none' );
            jQuery('.lapsha'  ).css( 'display', 'none' );
            jQuery('.pizza'   ).css( 'display', 'none' );
            jQuery('.vok'     ).css( 'display', 'none' );
            jQuery('.deserty' ).css( 'display', 'none' );
            jQuery('.napitki' ).css( 'display', 'none' );
        }
        else
        {
            jQuery('#page #supy'    ).css( 'display', 'inline' );
            jQuery('#page #supy2'   ).css( 'display', 'none' );
            jQuery('#page #salaty'  ).css( 'display', 'inline' );
            jQuery('#page #salaty2' ).css( 'display', 'none' );
            jQuery('#page #rolly'   ).css( 'display', 'inline' );
            jQuery('#page #rolly2'  ).css( 'display', 'none' );
            jQuery('#page #lapsha'  ).css( 'display', 'inline' );
            jQuery('#page #lapsha2' ).css( 'display', 'none' );
            jQuery('#page #pizza'   ).css( 'display', 'inline' );
            jQuery('#page #pizza2'  ).css( 'display', 'none' );
            jQuery('#page #vok'     ).css( 'display', 'inline' );
            jQuery('#page #vok2'    ).css( 'display', 'none' );
            jQuery('#page #deserty' ).css( 'display', 'inline' );
            jQuery('#page #deserty2').css( 'display', 'none' );
            jQuery('#page #napitki' ).css( 'display', 'inline' );
        }
    }

    function switchImage( divName, index )
    {
        var div = jQuery('#'+divName);
        var tmp = div.css( 'background-image' );
        div.css( 'background-image', imgArr[index] );
        imgArr[index] = tmp;
    }
</script>
</head>

<body>

<?php include_once("analyticstracking.php"); ?>
<?php include_once("yandexmetrika.php"); ?>

<div id="page">

    <a id="logo" href="index.php"></a>

	<div id='gifts' style='z-index:1;'></div>
	<div id='gift1' style='z-index:1; display: none;'></div>
	<div id='gift2' style='z-index:1; display: none;'></div>
	<div id='gift3' style='z-index:1; display: none;'></div>
	<div id='gift4' style='z-index:1; display: none;'></div>
	<div id='giftarea1' style='z-index:1;'></div>
	<div id='giftarea2' style='z-index:1;'></div>
	<div id='giftarea3' style='z-index:1;'></div>
	<div id='giftarea4' style='z-index:1;'></div>

    <div id="div1"></div>
    <div id="div2">
        <div id="div2_1"></div>
        <div id="div2_2">
            <div id='div2_2_close'></div>
            <div id='div2_2_inner'>
                <div id='leftModules'><jdoc:include type="modules" name="leftmainmenu" style="xhtml" /></div>
                <div id="centerModules">
                    
                    <a id='supy'     class='supy'     title='Cупы'      href="index.php?option=com_virtuemart&page=shop.browse&category_id=12&pcat_id=12&Itemid=64" style="background:url(templates/<?php echo $this->template ?>/images/soup1.png)"></a>
                    <a id='supy2'    class='supy'     title='Cупы'      href="index.php?option=com_virtuemart&page=shop.browse&category_id=12&pcat_id=12&Itemid=64" style="background:url(templates/<?php echo $this->template ?>/images/soup2.png)"></a>
                    <a id='salaty'   class='salaty'   title='Салаты'    href="index.php?option=com_virtuemart&page=shop.browse&category_id=11&pcat_id=11&Itemid=64" style="background:url(templates/<?php echo $this->template ?>/images/salaty1.png)"></a>
                    <a id='salaty2'  class='salaty'   title='Салаты'    href="index.php?option=com_virtuemart&page=shop.browse&category_id=11&pcat_id=11&Itemid=64" style="background:url(templates/<?php echo $this->template ?>/images/salaty2.png)"></a>
                    <a id='rolly'    class='rolly'    title='Роллы'     href="index.php?option=com_virtuemart&page=shop.browse&category_id=19&pcat_id=19&Itemid=64" style="background:url(templates/<?php echo $this->template ?>/images/rolly1.png)"></a>
                    <a id='rolly2'   class='rolly'    title='Роллы'     href="index.php?option=com_virtuemart&page=shop.browse&category_id=19&pcat_id=19&Itemid=64" style="background:url(templates/<?php echo $this->template ?>/images/rolly2.png)"></a>
                    <a id='lapsha'   class='lapsha'   title='Китайская лапша'  href="index.php?option=com_virtuemart&page=shop.browse&category_id=18&pcat_id=18&Itemid=64" style="background:url(templates/<?php echo $this->template ?>/images/lapsha1.png)"></a>
                    <a id='lapsha2'  class='lapsha'   title='Китайская лапша'  href="index.php?option=com_virtuemart&page=shop.browse&category_id=18&pcat_id=18&Itemid=64" style="background:url(templates/<?php echo $this->template ?>/images/lapsha2.png)"></a>
                    <a id='pizza'    class='pizza'    title='Пицца'     href="index.php?option=com_virtuemart&page=shop.browse&category_id=6&pcat_id=6&Itemid=64" style="background:url(templates/<?php echo $this->template ?>/images/pizza1.png)"></a>
                    <a id='pizza2'   class='pizza'    title='Пицца'     href="index.php?option=com_virtuemart&page=shop.browse&category_id=6&pcat_id=6&Itemid=64" style="background:url(templates/<?php echo $this->template ?>/images/pizza2.png)"></a>
                    <a id='vok'      class='vok'      title='Вок-меню'  href="index.php?option=com_virtuemart&page=shop.browse&category_id=8&pcat_id=8&Itemid=64" style="background:url(templates/<?php echo $this->template ?>/images/vok1.png)"></a>
                    <a id='vok2'     class='vok'      title='Вок-меню'  href="index.php?option=com_virtuemart&page=shop.browse&category_id=8&pcat_id=8&Itemid=64" style="background:url(templates/<?php echo $this->template ?>/images/vok2.png)"></a>
                    <a id='deserty'  class='deserty'  title='Десерты'   href="index.php?option=com_virtuemart&page=shop.browse&category_id=14&pcat_id=14&Itemid=64" style="background:url(templates/<?php echo $this->template ?>/images/deserty1.png)"></a>
                    <a id='deserty2' class='deserty'  title='Десерты'   href="index.php?option=com_virtuemart&page=shop.browse&category_id=14&pcat_id=14&Itemid=64" style="background:url(templates/<?php echo $this->template ?>/images/deserty2.png)"></a>
                    <a id='napitki'  class='napitki'  title='Напитки'   href="index.php?option=com_virtuemart&page=shop.browse&category_id=13&pcat_id=13&Itemid=64"></a>

                </div>
                <div id="rightModules"><jdoc:include type="modules" name="right" style="xhtml" />
                    <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?49"></script>
                    <!-- VK Widget -->
                    <div id="vk_groups"></div>
                    <script type="text/javascript">
                        VK.Widgets.Group("vk_groups", {mode: 1, width: "155", height: "120"}, 37435683);
                    </script>
                </div>
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
    <div id="div4">
        <div id="div4_1">
            <jdoc:include type="modules" name="seo_footer_tags" style="xhtml" />
        </div>
        <div id='div4_container'>
            <div id="div4_2">
            </div>
            <div id="div4_3">
            </div>
            <div id='div4_content'>
                <jdoc:include type="modules" name="seo_footer_text" style="xhtml" />
            </div>
        </div>
    </div>

</div>

 <!--jdoc:include type="component" style="xhtml" /-->

</body>
</html>
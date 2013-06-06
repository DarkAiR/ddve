<?php
// no direct access
 defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/template.css" type="text/css" />

<script src="templates/<?php echo $this->template ?>/js/jquery-1.6.2.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(
        function()
        {
            // Кэшируем
            img22_over = new Image();
            img22_over.src = "templates/<?php echo $this->template ?>/images/img_03_open.jpg";
            img22_over.onclick = change;
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

            jQuery('#info2').live('click', function(e)
            {
                if (window.getSelection) { window.getSelection().removeAllRanges(); }
                else if (document.selection && document.selection.clear)
                  document.selection.clear();
            });
            jQuery('#div2_2').live('click', function(e)
            {
                if (window.getSelection) { window.getSelection().removeAllRanges(); }
                else if (document.selection && document.selection.clear)
                  document.selection.clear();
            });

            // Выравниваем страницу по центру
            var wnd = jQuery(window);
            var offs = (1280-wnd.width())/2;
            document.documentElement.scrollLeft = offs;
            document.body.scrollLeft = offs;
            var e = jQuery('html, body');
            e.animate({'scrollLeft': offs});
        }
    );

    var isOpen = false;
    function change()
    {
        isOpen = !isOpen;
        switchImage( "div2_2", 22 );
        switchImage( "div3_1", 31 );
        switchImage( "div3_2", 32 );
        switchImage( "div3_3", 33 );
        jQuery('#info2').css( 'display', isOpen?'block':'none' );
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

<div id="page">

    <div id="div1"><div id="info1" style='padding:0px'>

        <form action="index.php" method="post" name="login" id="form-login">
        <fieldset class="input">
                <p id="form-login-username">
                        <input name="username" id="username" type="text" class="inputbox" alt="<?php echo JText::_('Username') ?>" size="18" />
                </p>
                <p id="form-login-password">
                        <input type="password" name="passwd" class="inputbox" size="18" alt="<?php echo JText::_('Password') ?>" id="passwd" />
                </p>
                <input type="submit" name="Submit" class="button" value="<?php echo JText::_('LOGIN') ?>" />
        </fieldset>
        <input type="hidden" name="option" value="com_user" />
        <input type="hidden" name="task" value="login" />
        <input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()) ?>" />
        <?php echo JHTML::_( 'form.token' ); ?>
        </form>

        <br/>
        <center>Открытие ресторана 11 сентября!</center>

        </div></div>
    <div id="div2">
        <div id="div2_1"></div>
        <div id="div2_2">

        </div>
        <div id="div2_3"></div>
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

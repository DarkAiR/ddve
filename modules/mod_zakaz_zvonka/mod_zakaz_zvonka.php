<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

JHTML::script( 'jquery.maskedinput.js' );
JHTML::script( 'jquery.balloon.min.js' );
?>

<div id="zz1">
    <input id='zakaz_zvonka' name="phone" value="" type="text" size="12" />
</div>
<div id="zz2">
    <img id="zakaz_zvonka" src="modules/mod_zakaz_zvonka/images/zakaz_zvonka<?php if( $params->get('type')==0 ) echo '_mainmenu'; ?>.png" onclick="zakaz()" style="cursor:pointer;" />
</div>

<script type="text/javascript">
    jQuery(function($)
    {
        jQuery('input#zakaz_zvonka')
            .mask('+7 9999-99-99-99')
            .balloon({
                contents:'Городской номер должен начинаться с кода города.<br/>Для Нижнего Тагила - +7 3435-ваш_номер',
                minLifetime: 0,
                showDuration: 0,
                hideDuration: 0
            });
    });


    var isSend = false;
    var inputZZ = jQuery('input#zakaz_zvonka');

    function zakaz()
    {
        if( isSend == true )
            return;

        // Стираем номер
        var val = inputZZ.val();
        if (val === '')
            return;

        inputZZ.val('');

        isSend = true;
        var dataArr = 'phone='+val;
        jQuery.ajax({
            type: "POST",
            url: "/ajax/zakaz_zvonka.php",
            processData: false,
            data: dataArr,
            success: function( data )
            {
                isSend = false;

                // Грязный хак - обрезаем идентификатор UNICODE
                if( data.charAt(0) != '{' )
                    data = data.substr( 3 );

                data = eval('(' + data + ')');
                if( data.result == 'success' )
                    jAlert( 'Ваш номер отправлен.\nВ ближайшее время мы с вами свяжемся.', 'Номер отправлен' );
                else
                    jAlert( 'Проверьте правильность введенного номера.\nГородской номер должен начинаться с кода города.\nДля Нижнего Тагила - +7 3435-ваш_номер', 'Неправильно введен номер телефона' );
            }
        });
    }

</script>

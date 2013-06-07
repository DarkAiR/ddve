<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
?>

<div id="zz1">
    <input id='zakaz_zvonka' name="phone" value="" type="text" size="12" />
</div>
<div id="zz2">
    <img id="zakaz_zvonka" src="modules/mod_zakaz_zvonka/images/zakaz_zvonka<?php if( $params->get('type')==0 ) echo '_mainmenu'; ?>.png" onclick="zakaz()" style="cursor:pointer;" />
</div>

<script>
    var isSend = false;

    var emptyValue = '  8 (    )    -   -';
    var inputZZ = jQuery('input#zakaz_zvonka');
    inputZZ.val( emptyValue );
    inputZZ.focus( function()
    {
        if( inputZZ.val() == emptyValue )
            inputZZ.val( '' );
    } );
    inputZZ.blur( function()
    {
        var val = inputZZ.val();
        if( val == '' )
        {
            inputZZ.val( emptyValue );
            return;
        }
    } );

    function checkPhone( val )
    {
        var tmp = val.replace( /\D/g, '' );
        if( tmp.length != 11 )      // Длина телефонного номера
            return false;
        return true;
    }

    function zakaz()
    {
        if( isSend == true )
            return;

        var val = inputZZ.val();

        // Проверяем корректность
        if( checkPhone( val ) == false )
        {
            zakazError();
            return;
        }

        // Стираем номер
        inputZZ.val( emptyValue );

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
                    zakazError();
            }
        });
    }

    function zakazError()
    {
        jAlert( 'Проверьте правильность введенного номера.\nГородской номер должен начинаться с кода города.\nДля Нижнего Тагила - 8(3435)ваш_номер', 'Неправильно введен номер телефона' );
    }
    
</script>

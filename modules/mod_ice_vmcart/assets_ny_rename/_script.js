/*----------------------------------------------------------------
  Copyright:
  (C) 2008 - 2010 IceTheme

  License:
  GNU/GPL http://www.gnu.org/copyleft/gpl.html

  Author:
  IceTheme - http://wwww.icetheme.com
---------------------------------------------------------------- */

var isVmCartVisible = false;
var vmCartScrollTop = jQuery(window).scrollTop();
var vmCartTopButton = 0;
var pageHeaderHeight = 285;

var startCartChangeAmount = false;
var startUpdataMiniCarts = false;

jQuery(document).ready( function()
{
    vmCartTopButton = parseInt( jQuery('#vm_cart_button').css('top') ) + pageHeaderHeight;
});

// Отслеживаем изменение размеров окна, чтобы позиционировать корзину
jQuery(window).resize( function()
{
    if( isVmCartVisible )
        vmCartPositionWindowByButton();
});

jQuery(window).scroll( function()
{
    if( isVmCartVisible )
        return;
    
    // Сколько расстояние до верха
    var maxTop = 120;

    var topOffset = jQuery(window).scrollTop();
    var deltaTopOffset = topOffset - vmCartScrollTop;
    vmCartScrollTop = topOffset;

    console.log( vmCartScrollTop + " : " + (topOffset + maxTop - pageHeaderHeight) );

    var elem = jQuery('#vm_cart_button');
    vmCartTopButton -= deltaTopOffset;
    if( vmCartTopButton < maxTop )
        elem.css( 'top', topOffset + maxTop - pageHeaderHeight );
    else
        elem.css( 'top', maxTop );
    vmCartPositionWindowByButton();
});

function vmCartPositionWindowByButton()
{
    var posElem = jQuery('#vm_cart_button').position();
    posElem.left -= 10;
    posElem.top -= 10;
    jQuery('#vm_cart_window').css( 'left', posElem.left );
    jQuery('#vm_cart_window').css( 'top',  posElem.top );
}

function vmCartButtonClick( elem )
{
    if( isVmCartVisible )
    {
        jQuery('#vm_cart_window').hide( 'fast' );
        jQuery('#vm_cart_bg').empty();
    }
    else
    {
        var posElem = jQuery(elem).position();
        posElem.left -= 10;
        posElem.top -= 10;
        jQuery('#vm_cart_window').css( 'left', posElem.left );
        jQuery('#vm_cart_window').css( 'top',  posElem.top );
        jQuery('#vm_cart_window').show( 'fast' );
        jQuery('#vm_cart_bg').append('<div id="TB_overlay"></div>');

        // Выставляем равный размер
        h1 = jQuery('#vm_cart_list').height();
        h2 = jQuery('#vm_cart_form').height();
        h = 0;
        if( h1 < h2 )
        {
            jQuery('#vm_cart_list').height( h2 );
            h = h2;
        }
        else
        {
            jQuery('#vm_cart_form').height( h1 );
            h = h1;
        }

        // Задник
        jQuery('#vm_cart_window_bg').css( 'top', 516 ).css( 'left', 0 ).height( h-516+83 );
    }

    isVmCartVisible = !isVmCartVisible;
}


var vmCartIsSend = false;

function vmCartFormSend( elem )
{
    if( vmCartIsSend == true )
        return;

    var checkPhone = function( val )
    {
        var tmp = val.replace( /\D/g, '' );
        if( tmp.length != 11 )      // Длина телефонного номера
            return false;
        return true;
    };

    var cartFormError = function( elem )
    {
        elem.addClass( 'formerror' );

        var str = 'Пожалуйста убедитесь в правильности ввода данных!';
        jQuery('#vm_cart_form #result').empty().append( str );
    }

    jQuery('#vm_cart_form #result').empty();

    // Подменяем список продуктов
    jQuery('#mmprodList').val( jQuery('#mprodList').text() );

    var arrName = new Array( 'name', 'phone', 'email', 'street', 'house', 'corpus', 'kvartira', 'podezd', 'amperson', 'comment', 'prodList' );
    var params = '';
    for( var i = 0;  i < arrName.length;  i++ )
    {
        v = arrName[i];
        eval( 'var '+ v +'_elem = jQuery("#vm_cart_form [name=\''+ v +'\']");' );
        eval( 'var '+ v +' = '+ v +'_elem.val();' );
        eval( v +'_elem.removeClass( "formerror" );' );
        params += v + '=' + encodeURIComponent( eval( v ) ) + '&';
    }
    params += 'persons=' + jQuery('#total_block #person_amount #person_quantity').attr("value");

    // Проверяем корректность
    console.log( params );
    err = false;
    if( name.trim().length == 0 )
    {
        cartFormError( name_elem );
        err = true;
    }
    if( checkPhone( phone ) == false )
    {
        cartFormError( phone_elem );
        err = true;
    }
    if( err )
        return;

    // Очищаем все пункты
    for( i = 0;  i < arrName.length;  i++ )
    {
        v = arrName[i];
        jQuery("#vm_cart_form [name='"+ v +"']").val('');
    }

    vmCartIsSend = true;
    jQuery.ajax({
        type: "POST",
        url: "/ajax/send_order.php",
        processData: false,
        data: params,
        success: function( data )
        {
            vmCartIsSend = false;

            // Грязный хак - обрезаем идентификатор UNICODE
            if( data.charAt(0) != '{' )
                data = data.substr( 3 );

            data = eval('(' + data + ')');

            if( data.result == 'success' )
                jAlert( 'Ваш заказ отправлен.', 'Заказ отправлен' );
            else
                jAlert( 'Извините, произошел сбой при отправке Вашего заказа.\nПожалуйста повторите попытку.', 'Заказ не отправлен' );
            console.log( data );
        }
    });
}

// Убрать красный фон поля input при возврате фокуса
function vmCartFormFocus( elem )
{
    jQuery(elem).removeClass( "formerror" );
}


// Обработка кнопок
function vmCartMinus( elem, itemId )
{
    var productId = parseInt( jQuery(elem).attr('productId') );
    var quantity  = parseInt( jQuery(elem).attr('quantity') );
    console.log( 'minus '+productId+' = '+quantity );

    if( quantity <= 0 )
        return;

    itemsToAdd = -1;
    vmCartChangeAmount( productId, itemId, 'cartSub' );
}

function vmCartPlus( elem, itemId )
{
    var productId = parseInt( jQuery(elem).attr('productId') );
    console.log( 'plus '+productId );

    itemsToAdd = 1;
    vmCartChangeAmount( productId, itemId, 'cartAdd' );
}

function vmCartChangeAmount( productId, itemId, cartFunc )
{
    console.log( "vmCartChangeAmount" );
    if( startCartChangeAmount == true  ||  startUpdataMiniCarts == true )
        return;
    console.log( 'start!' );
    startCartChangeAmount = true;

    var callback = function(responseText)
    {
        console.log( 'vmCartChangeAmount end!!!' );
        startCartChangeAmount = false;
        console.log( responseText );
        updateMiniCarts();
    }
    var option =
    {
        method: 'post',
        onComplete: callback,
        data: {
            "option": "com_virtuemart",
            "page": "shop.browse",
            "Itemid": itemId,
            "func": cartFunc,
            "prod_id": productId,
            "product_id": productId,
            "quantity": itemsToAdd,
            "set_price[]": "",
            "adjust_price[]": "",
            "master_product[]": ""
        }
    };
    //console.log( option );
    new Ajax( live_site + '/index2.php', option ).request();
}

function vmCartDelete( elem, itemId )
{
    var productId = parseInt( jQuery(elem).attr('productId') );
    var quantity  = parseInt( jQuery(elem).attr('quantity') );
    console.log( 'delete '+productId+' = '+quantity );

    itemsToAdd = -quantity;

    var callback = function(responseText)
    {
        console.log( responseText );
        updateMiniCarts();
    }
    var option =
    {
        method: 'post',
        onComplete: callback,
        data: {
            "option": "com_virtuemart",
            "page": "shop.browse",
            "Itemid": itemId,
            "func": "cartDelete",
            "product_id": productId,
            "description": '',
            "delete": "delete"
        }
    };
    new Ajax( live_site + '/index2.php', option ).request();
}

// Добавление товара
$(window).addEvent('domready', function()
{
    handleAddToCart = function( formId, parameters ) {
        formCartAdd = document.getElementById( formId );
        itemsToAdd = 1;

        var callback = function(responseText) {
            updateMiniCarts();
            // close an existing mooPrompt box first, before attempting to create a new one (thanks wellsie!)
            if (document.boxB) {
                document.boxB.close();
                clearTimeout(timeoutID);
            }

            document.boxB = new MooPrompt(notice_lbl, responseText, {
                    buttons: 1,
                    width:400,
                    height:150,
                    overlay: false,
                    button1: ok_lbl
                    //button2: cart_title
                    //onButton2:         handleGoToCart
                });

            setTimeout( 'document.boxB.close()', 3000 );
        }

        var opt =
        {
            method: 'post',
            data: $(formId),
            onComplete: callback,
            evalScripts: true
        };

        new Ajax(formCartAdd.action, opt).request();
    }
    /**
    * This function searches for all elements with the class name "vmCartModule" and
    * updates them with the contents of the page "shop.basket_short" after a cart modification event
    */
    updateMiniCarts = function()
    {
        console.log( 'updateMiniCarts' );
        if( startUpdataMiniCarts == true )
            return;
        startUpdataMiniCarts = true;
        console.log( 'updateMiniCarts start!!!' );

        var callbackCart = function( responseText )
        {
            startUpdataMiniCarts = false;
            console.log( 'updateMiniCarts end!!!' );
            //console.log( responseText );

            var basketAmount = $('vm_cart_button').getElement('span');
            var newAmount = parseInt( basketAmount.innerHTML ) + parseInt( itemsToAdd );

            var carts = document.getElementById('vm_cart_list');
            if( carts )
            {
                try
                {
                    carts.innerHTML = responseText;
                    basketAmount.innerHTML = newAmount;
                }
                catch(e) {}
            }
        }
        var option = {method: 'post', onComplete: callbackCart, data: {only_page:1,page: "shop.basket_list", option: "com_virtuemart"}}
        new Ajax( live_site + '/index2.php', option).request();
    }
});

/*
// Override the VirtueMart function;
$(window).addEvent('domready', function()
{
        // Override the handleAddToCart function;
    handleAddToCart = function(formId, parameters)
    {
        formCartAdd = $(formId);
        itemsToAdd = 1;
        //var vmCart = new Fx.Slide("cart-panel");
        var myElement = document.getElementById('cart-panel');
        var mySlwa = 2;
        new Ajax(formCartAdd.action, {
            method: 'post',
            postBody: $(formId).toQueryString(),
            evalScripts: true,
            onComplete: function(responseText) {
                if(mySlwa == 2){
                    mySlwa = 1;
                }
                setTimeout( function(){
                    if( $defined($('cart_overlay')) ) {
                        $('cart_overlay').setStyles({
                            "visibility": 'hidden'
                        });
                    }
                },1500);
                updateMiniCarts();
                $('vm_cart').className = 'vm_cart-full';
            }
        }).request();
    }

/*
        // Override the handleAddToCart function;
    updateMiniCarts = function() {
        var cartPanel = $('cart-panel');
        var mika = $('cart-button').getElement('strong');
        ex1 = parseInt(mika.innerHTML);
        ex2 = parseInt(itemsToAdd);
        ex3 = ex1+ex2;

        new Ajax(live_site + '/index2.php', {
            method: 'post',
            postBody: Object.toQueryString({
                "only_page": "1",
                "page": "shop.basket_short",
                "option": "com_virtuemart"
            }),
            onComplete: function(responseText) {
                carts = $('ice_cart').getElement('.ice-content');
                if( carts ) {
                    try {
                        carts.innerHTML = responseText;
                        mika.innerHTML = ex3;
                    } catch(e) {
                    // ...
                    }
                    $('cart-panel').addClass('ice-hide');
                    IceSliderCart(true);
                }
            }
        }).request();
    }
});*/


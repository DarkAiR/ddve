vmcart = {
    isVisible: false,
    scrollTop: 0,                   // Расстояния скролла
    topButton: 0,                   // Расстояние от кнопки до верха страницы
    isFormSend: false,              // Форма отправлена
    startCartChangeAmount: false,
    startUpdataMiniCarts: false,

    init: function()
    {
        vmcart.topButton = jQuery('#js-vm_cart_button').offset().top;
        vmcart.scrollTop = jQuery(window).scrollTop();

        jQuery(window).resize(vmcart.resize);
        jQuery(window).scroll(vmcart.onScroll);
    },

    // Отслеживаем изменение размеров окна, чтобы позиционировать корзину
    resize: function()
    {
        if( vmcart.isVisible )
            vmcart.positionWindowByButton();
    },

    onScroll: function()
    {
        vmcart.scroll(false);
    },

    scroll: function(isAnimate)
    {
        if( vmcart.isVisible )
            return;

        var $cartButton = jQuery('#js-vm_cart_button');
        var $content = jQuery('#js-content');

        var maxTop = 120;   // Сколько расстояние до верха
        var scrollTop = jQuery(window).scrollTop();
        var buttonTop = null;

        // Верх
        if (scrollTop > vmcart.topButton - maxTop) {
            buttonTop = scrollTop + maxTop;
        }

        // Низ. Если корзина вылазит за контент, то не даем ей это сделать
        var contentBottom = $content.height() + $content.offset().top;
        if (contentBottom - scrollTop < $cartButton.height() + maxTop) {
            buttonTop = contentBottom - $cartButton.height();
        }

        if (buttonTop != null) {
            if (isAnimate)
                $cartButton.animate({'top':buttonTop - $cartButton.parent().offset().top}, 100);
            else
                $cartButton.offset({'top':buttonTop});
        }

        vmcart.positionWindowByButton();
    },

    positionWindowByButton: function()
    {
        var posElem = jQuery('#js-vm_cart_button').position();
        posElem.left -= 10;
        posElem.top -= 10;
        jQuery('#js-vm_cart_window').css({
            'left': posElem.left,
            'top':  posElem.top
        });
    },

    calcNewSize: function()
    {
        // Выставляем равный размер
        h1 = jQuery('#js-vm_cart_list-inner').height() + jQuery('#js-vm_cart_window_action').height();
        h2 = jQuery('#js-vm_cart_form-inner').height();

        h = ( h1 <= h2 ) ? h2 : h1;
        jQuery('#js-vm_cart_list').height(h);
        jQuery('#js-vm_cart_form').height(h);

        // Задник
        jQuery('#js-vm_cart_window_bg')
            .css({'top':516, 'left':0})
            .height( h - 516 + 81 );   // Какая-то магическая хуйня
    },

    toggleButton: function()
    {
        var $cartButton = jQuery('#js-vm_cart_button');

        if( vmcart.isVisible ) {
            jQuery('#js-vm_cart_window').hide('fast', function() {
                vmcart.scroll(true);
            });
            jQuery('#js-vm_cart_bg').empty();
        } else {
            var posElem = $cartButton.position();
            posElem.left -= 10;
            posElem.top -= 10;
            jQuery('#js-vm_cart_window')
                .css({'left': posElem.left, 'top':posElem.top})
                .show('fast');
            jQuery('#js-vm_cart_bg').append('<div id="TB_overlay"></div>');

            vmcart.calcNewSize();
        }
        vmcart.isVisible = !vmcart.isVisible;
    },

    formSend: function( elem )
    {
        if( vmcart.isFormSend == true )
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
            jQuery('#js-vm_cart_form #result').empty().append( str );
        }

        jQuery('#js-vm_cart_form #result').empty();

        // Подменяем список продуктов
        jQuery('#mmprodList').val( jQuery('#mprodList').text() );

        var arrName = new Array( 'name', 'phone', 'email', 'street', 'house', 'corpus', 'kvartira', 'podezd', 'amperson', 'comment', 'prodList' );
        var params = '';
        for( var i = 0;  i < arrName.length;  i++ ) {
            v = arrName[i];
            eval( 'var '+ v +'_elem = jQuery("#js-vm_cart_form [name=\''+ v +'\']");' );
            eval( 'var '+ v +' = '+ v +'_elem.val();' );
            eval( v +'_elem.removeClass( "formerror" );' );
            params += v + '=' + encodeURIComponent( eval( v ) ) + '&';
        }
        params += 'persons=' + jQuery('#total_block #person_amount #person_quantity').attr("value");

        // Проверяем корректность
        err = false;
        if( name.trim().length == 0 ) {
            cartFormError( name_elem );
            err = true;
        }
        if( checkPhone( phone ) == false ) {
            cartFormError( phone_elem );
            err = true;
        }
        if( err )
            return;

        // Очищаем все пункты
        for( i = 0;  i < arrName.length;  i++ ) {
            v = arrName[i];
            jQuery("#js-vm_cart_form [name='"+ v +"']").val('');
        }

        vmcart.isFormSend = true;
        jQuery.ajax({
            type: "POST",
            url: "/ajax/send_order.php",
            processData: false,
            data: params,
            success: function( data ) {
                vmcart.isFormSend = false;

                // Грязный хак - обрезаем идентификатор UNICODE
                if( data.charAt(0) != '{' )
                    data = data.substr( 3 );

                data = eval('(' + data + ')');

                if( data.result == 'success' )
                    jInfo( 'В течение 15 минут с вами свяжется наш оператор', 'Ваш заказ отправлен на кухню' );
                else
                    jInfo( 'Извините, произошел сбой при отправке Вашего заказа.\nПожалуйста повторите попытку.', 'Заказ не отправлен' );
            }
        });
    },

    // Убрать красный фон поля input при возврате фокуса
    formFocus: function( elem )
    {
        jQuery(elem).removeClass("formerror");
    },

    // Убирание товара из корзины
    minus: function( elem, itemId )
    {
        var productId = parseInt( jQuery(elem).attr('productId') );
        var quantity  = parseInt( jQuery(elem).attr('quantity') );
        if( quantity <= 0 )
            return;

        itemsToAdd = -1;
        vmcart.changeAmount(productId, itemId, 'cartSub');
    },

    // Увеличение количества товара в корзине
    plus: function( elem, itemId )
    {
        var productId = parseInt( jQuery(elem).attr('productId') );

        itemsToAdd = 1;
        vmcart.changeAmount(productId, itemId, 'cartAdd');
    },

    changeAmount: function( productId, itemId, cartFunc )
    {
        if( vmcart.startCartChangeAmount == true  ||  vmcart.startUpdataMiniCarts == true )
            return;
        vmcart.startCartChangeAmount = true;

        var callback = function(responseText)
        {
            vmcart.startCartChangeAmount = false;
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
        new Ajax( live_site + '/index2.php', option ).request();
    },

    delete: function( elem, itemId )
    {
        var productId = parseInt( jQuery(elem).attr('productId') );
        var quantity  = parseInt( jQuery(elem).attr('quantity') );

        itemsToAdd = -quantity;

        var callback = function(responseText)
        {
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
};


jQuery(document).ready( function() {
    vmcart.init();
});


// Добавление товара
$(window).addEvent('domready', function()
{
    handleAddToCart = function( formId, parameters )
    {
        formCartAdd = document.getElementById( formId );
        itemsToAdd = 1;

        var callback = function(responseText) {
            updateMiniCarts();

            if( parameters.onload )
            {
                parameters.onload();
                return;
            }

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
        if (vmcart.startUpdataMiniCarts == true)
            return;
        vmcart.startUpdataMiniCarts = true;

        var callbackCart = function( responseText )
        {
            vmcart.startUpdataMiniCarts = false;

            var basketAmount = jQuery('#js-vm_cart_button span');
            var newAmount = parseInt( basketAmount.html() ) + parseInt( itemsToAdd );

            var carts = jQuery('#js-vm_cart_list-inner');
            if( carts ) {
                carts.html(responseText);
                basketAmount.html(newAmount);
            }

            if (vmcart.isVisible)
                vmcart.calcNewSize();
        }
        var option = {method: 'post', onComplete: callbackCart, data: {only_page:1,page: "shop.basket_list", option: "com_virtuemart"}}
        new Ajax( live_site + '/index2.php', option).request();
    }
});
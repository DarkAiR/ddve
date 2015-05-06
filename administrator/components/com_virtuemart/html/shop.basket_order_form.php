﻿<?php

if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

$totalPrice = 0;
$cartStr = '';

$pos = 1;
foreach( $minicart as $idx => $cart )
{
    if( intval($cart['quantity']) > 0 )
    {
        $cartStr .= "$pos. {$cart['product_name']}\r\n".
                    "      Артикул: {$cart['product_sku']}\r\n".
                    "      Кол-во:  {$cart['quantity']} [{$cart['packaging']}]\r\n".
                    "      Цена:    {$cart['price']}\r\n".
                    "\r\n";
        $totalPrice += $cart['price'];
        $pos++;
    }
}
$cartStr .= "Общая стоимость: $totalPrice\r\n";


?>
<form method="POST" action="">
    <div class='title'>Контактные данные:</div>
    <label for="field1" >Имя: <ss>*</ss></label>        <input id="field1"  type="text"     name="name"     value="" size="40" onfocus="vmcart.formFocus(this)"/><br/>
    <label for="field2" >Телефон: <ss>*</ss></label>    <input id="field2"  type="text"     name="phone"    value="" size="40" onfocus="vmcart.formFocus(this)"/><br/>
    <label for="field3" >Email:</label>                 <input id="field3"  type="text"     name="email"    value="" size="40"/><br/>
    <label for="field4" >Улица:</label>                 <input id="field4"  type="text"     name="street"   value="" size="40"/><br/>
    <label for="field5" >Дом:</label>                   <input id="field5"  type="text"     name="house"    value="" size="40"/><br/>
    <label for="field6" >Корпус:</label>                <input id="field6"  type="text"     name="corpus"   value="" size="40"/><br/>
    <label for="field7" >Квартира/офис:</label>         <input id="field7"  type="text"     name="kvartira" value="" size="40"/><br/>
    <label for="field9" >Подъезд:</label>               <input id="field9"  type="text"     name="podezd"   value="" size="40"/><br/>
    <label for="field8" >Кол-во персон:</label>         <input id="field8"  type="text"     name="amperson" value="" size="40"/><br/>
    <label for="field10">Комментарий:</label>           <textarea id="field10" rows="4"     name="comment"  value="" size="40"></textarea>
    <input id='mmprodList' type="hidden" name="prodList" value="<?php echo $cartStr ?>"/>
    <div id='result'>
        &nbsp;
    </div>
    <div id='submitBtn'>
        <input type="button" value=""
               onmouseover="jQuery(this).addClass('activeBtn')"
               onmouseout ="jQuery(this).removeClass('activeBtn')"
               onclick="vmcart.formSend(this)"
        />
    </div>
</form>

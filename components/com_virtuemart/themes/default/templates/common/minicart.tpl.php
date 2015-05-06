<?php
/**
 * @Copyright Copyright (C) 2008 - 2010 IceTheme
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * **** */
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) )
    die( 'Direct Access to ' . basename( __FILE__ ) . ' is not allowed.' );

if( $empty_cart )
{
    echo $VM_LANG->_( 'PHPSHOP_EMPTY_CART' );
}
else
{
    foreach( $minicart as $idx => $cart )
    {
        foreach( $cart as $attr => $val )
        {
            // Using this we make all the variables available in the template
            // translated example: $this->set( 'product_name', $product_name );
            $this->set( $attr, $val );
        }

        $attr = 'productId="'.$cart['product_id'].'" quantity="'.$cart['quantity'].'"';
        $shopItemId = ps_session::getShopItemid();
        ?>

        <div class="ice-basket-row">
            <div id="minus" onclick="vmcart.minus(this, '<?php echo $shopItemId ?>')" <?php echo $attr ?>></div>
            <div id="quantity"><input readonly type="text" name="quantity" value="<?php echo $cart['quantity'] ?>"/></div>
            <div id="plus"  onclick="vmcart.plus(this, '<?php echo $shopItemId ?>')"  <?php echo $attr ?>></div>
            <div id="title" ><?php echo $cart['product_name'] ?></div>
            <div id="weight"><?php echo $cart['weight'].'/'.$cart['packaging'] ?></div>
            <div id="price" ><?php echo $cart['price'] ?></div>
            <div id="delete" onclick="vmcart.delete(this, '<?php echo $shopItemId ?>' )" <?php echo $attr ?>>x</div>
        </div>

        <?php
    }
}
?>

<div id='total_block'>
    <hr noshade="noshade" color="#d8cbd3" size="1"/>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="50%">
                <!--div id='person_title'>Количество персон&nbsp;&nbsp;</div-->
                <!--div id="person_amount"><input id="person_quantity" type="text" name="quantity" value="1" onchange="console.log('onchange')"/></div-->
            </td>
            <td width="28%" align="right">
                <div id='total_title'>Итого: </div>
            </td>
            <td width="22%" align="right">
                <div id='total_amount'><?php echo $total_price ?></div>
            </td>
        </tr>
    </table>
</div>

<div id='mprodList' style='display:none'>
<?php
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
echo $cartStr;
?>
</div>


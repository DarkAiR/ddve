<?php
/**
 * @Copyright Copyright (C) 2008 - 2010 IceTheme
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * **** */
if( isset( $_SESSION['cart'] ) )
    $cart = $_SESSION['cart'];
$total = 0;
if( isset( $cart ) )
{
    foreach( $cart as $key => $item )
        $total += $item['quantity'];
}
if( $total > 0 )
{
    $totalString = $total;
    $cart = "class=\"vm_cart-full\"";
}
else
{
    $totalString = '0';
    $cart = "";
}

// if ($total > 0) $hideCart = '';
// else $hideCart = "style=\"display:none\"";
?>

<div id="vm_cart_button" <?php echo $cart; ?> onclick="vmCartButtonClick(this)">
    <span><?php echo $totalString; ?></span>
</div>

<div id="vm_cart_window">
    <div id="vm_cart_window_bg"></div>
    <div id="vm_cart_close"><a href="javascript:void(0)" onclick="vmCartButtonClick(getElementById('vm_cart_button'))">Закрыть <b>×</b></a></div>
    <div id="vm_cart_list">
        <?php include( PAGEPATH.'shop.basket_list.php' ); ?>
    </div>
    <div id="vm_cart_form">
        <?php include( PAGEPATH.'shop.basket_order_form.php' ); ?>
    </div>
    <div id="vm_cart_window_bottom"></div>
</div>

<div id="vm_cart_bg"></div>

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

<div class="vm_cart_button" id='js-vm_cart_button' <?php echo $cart; ?> onclick="vmcart.toggleButton(); yaCounter21519046.reachGoal('BASKET'); return true;">
    <span><?php echo $totalString; ?></span>
</div>

<div class="vm_cart_window" id='js-vm_cart_window'>
    <div class="vm_cart_window_bg" id='js-vm_cart_window_bg'></div>
    <div class="vm_cart_close"><a href="javascript:void(0)" onclick="vmcart.toggleButton()">Закрыть <b>×</b></a></div>
    <div class="vm_cart_list" id='js-vm_cart_list'>
        <?php include( PAGEPATH.'shop.basket_list.php' ); ?>
    
        <div class='vm_cart_window_action'>

        </div>
    </div>
    <div class='vm_cart_form' id='js-vm_cart_form'>
        <?php include( PAGEPATH.'shop.basket_order_form.php' ); ?>
    </div>
    <div class="vm_cart_window_bottom"></div>
</div>

<div id="js-vm_cart_bg"></div>

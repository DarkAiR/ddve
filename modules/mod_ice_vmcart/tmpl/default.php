<?php

// Получаем нужные акции
/*JLoader::import('joomla.application.component.model');
JLoader::import( 'actions', 'components' . DS . 'com_actions' . DS . 'models' );
$actionsModel = JModel::getInstance( 'actions', 'ActionsModel' );

$query = "SELECT * FROM #__actions WHERE rollday=1 ORDER BY rand() LIMIT 1";
$actionsModel->getDBO()->setQuery($query);
$actions = $actionsModel->getDBO()->loadAssocList();
*/

// Получаем нужные товары по акции
require_once( CLASSPATH . 'ps_database.php' );
$dbp = new ps_DB;
$dbp->setQuery("SELECT product_name FROM #__{vm}_product WHERE product_action='Y' ORDER BY RAND() LIMIT 1");
$productTitle = $dbp->loadResult();



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
        <div id='js-vm_cart_list-inner'>
            <?php include( PAGEPATH.'shop.basket_list.php' ); ?>
        </div>


<?php
    if ($productTitle) {
?>
        <div class='vm_cart_window_action' id='js-vm_cart_window_action'>
            <div class='action-main-title'>Акции и подарки!</div>
            <div class='action-inner-window'>
                <div class='upper-inner-window'>
                    <div class='icon'>
                    </div>
                    <div class='text1'>
                        Сегодня &laquo;Ролл дня&raquo;:
                    </div>
                    <div class='text2'>
                        <?php echo $productTitle; ?>
                    </div>
                </div>
                <div class='separator-inner-window'>
                </div>
                <div class='bottom-inner-window'>
                    <div class='text3'>
                        При заказе на сумму от 1300 руб и больше, особые роллы &ndash; в подарок!  
                    </div>
                </div>
            </div>
        </div>
<?php
    }
?>

    </div>
    <div class='vm_cart_form' id='js-vm_cart_form'>
        <div id='js-vm_cart_form-inner'>
            <?php include( PAGEPATH.'shop.basket_order_form.php' ); ?>
        </div>
    </div>
    <div class="vm_cart_window_bottom"></div>
</div>

<div id="js-vm_cart_bg"></div>

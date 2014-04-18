<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); 
mm_showMyFileName(__FILE__);

$button_lbl = $VM_LANG->_('PHPSHOP_CART_ADD_TO');
$button_cls = 'addtocart_button';
if( CHECK_STOCK == '1' && ( $product_in_stock < 1 ) ) {
	$button_lbl = $VM_LANG->_('VM_CART_NOTIFY');
	$button_cls = 'notify_button';
	$notify = true;
} else {
	$notify = false;
}

$thisId = str_replace('.','_',$i);
?>

<form   action="<?php echo $mm_action_url ?>index.php"
        method="post"
        name="addtocart"
        id="addtocart<?php echo $thisId; ?>"
        class="addtocart_form"
>
    <?php echo $ps_product_attribute->show_quantity_box($product_id,$product_id); ?><br />

    <div class="browseProductOrder">
        <div class="browseProductOrderLink">
            <a  href="javascript:void(0)"
                id="addtocart_order_<?php echo $thisId; ?>"
                data-container="body"
                data-toggle="popover"
                data-original-title="" title=""
                onclick="yaCounter21519046.reachGoal('ORDER'); return true;"
            ><?php echo $button_lbl ?></a></div>
    </div>
	<!--input type="submit" class="<?php echo $button_cls ?>" value="<?php echo $button_lbl	?>" title="<?php echo $button_lbl ?>" /-->
    <input type="hidden" name="category_id" value="<?php echo  @$_REQUEST['category_id'] ?>" />
    <input type="hidden" name="product_id" value="<?php echo $product_id ?>" />
    <input type="hidden" name="prod_id[]" value="<?php echo $product_id ?>" />
    <input type="hidden" name="page" value="shop.cart" />
    <input type="hidden" name="func" value="cartadd" />
    <input type="hidden" name="Itemid" value="<?php echo $sess->getShopItemid() ?>" />
    <input type="hidden" name="option" value="com_virtuemart" />
    <input type="hidden" name="set_price[]" value="" />
    <input type="hidden" name="adjust_price[]" value="" />
    <input type="hidden" name="master_product[]" value="" />
    <script type="text/javascript">
        jQuery(document).ready(function()
        {
            var popoverShow = false;

            var template = '' +
                '<div class="addtocart_popover">' +
                    '<div class="addtocart_header">' +
                        '<a class="addtocart_header_close" data-dismiss="modal" aria-hidden="true">Закрыть &times;</a>' +
                    '</div>' +
                    '<div class="addtocart_body">' +
                        '<div class="addtocart_body_inner">Блюдо добавлено в корзину</div>' +
                    '</div>' +
                '</div>';
            jQuery('#addtocart_order_<?php echo $thisId; ?>')
                .popover({
                    'placement':'bottom',
                    'trigger':'manual',
                    'content':'_',
                    'template':template
                })
                .click(function(ev)
                {
                    var self = jQuery(this);
                    if( popoverShow )
                        return false;
                    popoverShow = true;

                    var prevId = jQuery.data(document.body,'addToCartPopover');
                    if( prevId )
                        jQuery('#'+prevId).popover('hide');
                    jQuery.data(document.body, 'addToCartPopover', 'addtocart_order_<?php echo $thisId; ?>');

                    jQuery('#addtocart<?php echo $thisId; ?>').submit();
                    return false;
                });

                <?php if( $this->get_cfg( 'useAjaxCartActions', 1 ) && !$notify )
                { ?>
                    jQuery('#addtocart<?php echo $thisId; ?>')
                        .on('submit', function(ev)
                        {
                            handleAddToCart( this.id, {
                                'onload': function()
                                {
                                    var self = jQuery('#addtocart_order_<?php echo $thisId; ?>');
                                    self.popover('show');
                                    setTimeout( function()
                                    {
                                        self.popover('hide');
                                        popoverShow = false;
                                        jQuery.removeData(document.body, 'addToCartPopover');
                                    }, 2000)
                                }
                            });
                            return false;
                        });
                <?php
                } ?>
        });
    </script>
</form>

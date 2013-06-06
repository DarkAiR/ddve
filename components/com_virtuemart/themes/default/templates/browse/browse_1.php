<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
mm_showMyFileName(__FILE__);
 ?>

 <div class="browseProductContainer" onmouseover="this.id='browseItemOver'" onmouseout="this.id='browseItemOut'">

    <div class="browseProductImageContainer">
        <?php
		/*<script type="text/javascript">
            //document.write('<a href="javascript:void window.open(\'<?php echo $product_full_image ?>\', \'win2\', \'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=<?php echo $full_image_width ?>,height=<?php echo $full_image_height ?>,directories=no,location=no\');">');
            <?php
                $imgTag = ps_product::image_tag( urldecode($product_thumb_image), 'class="browseProductImage" border="0" title="'.$product_name.'" alt="'.$product_name .'"' );
                $hrefTag = vmCommonHTML::getLightboxImageLink( $product_full_image, $imgTag, $product_name, 'product' );
            ?>
            //document.write( '<?php echo $hrefTag ?>' );
        </script>*/
		?>
		<?php
			$imgTag = ps_product::image_tag( urldecode($product_thumb_image), 'class="browseProductImage" border="0" title="'.$product_name.'" alt="'.$product_name .'"' );
			$hrefTag = vmCommonHTML::getLightboxImageLink( $product_full_image, $imgTag, $product_name, 'product' );
			echo $hrefTag;
		?>
    </div>

    <div class="browseActionContainer" id="browseItemAction">
            <div class="<?php if( $product_action=='Y' ) echo 'browseItemAction'; ?>"></div>
    </div>
    <div class="browsePriceContainer <?php if( $product_special=='Y' ) echo 'browseItemPriceSpecial'; ?>" id="browseItemPrice">
        <?php echo $product_price ?>
    </div>
    <div class="browseProductTitle">
        <?php echo $product_name ?>
    </div>
    <div class="browseProductDescription">
        <?php echo $product_desc ?>
    </div>
    <div class="browseProductWeight">
        <?php echo intval($product_weight).' '.$product_weight_uom.'/ '.$product_packaging ?>
    </div>
    <!--div class="browseProductOrder">
        <div class="browseProductOrderLink"><a title="<?php echo $product_name ?>" href="<?php echo $product_flypage ?>">Заказать</a></div>
    </div-->
        
        
    <span class="browseAddToCartContainer">
        <?php echo $form_addtocart ?>
    </span>

</div>
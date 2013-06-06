<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
mm_showMyFileName(__FILE__); ?>


<?php 
/*
 * DarkAiR

if( sizeof($VM_BROWSE_FILTERBY_MF) < 2 ) {
	// return;
}
 * 
 */
return;

?>
<?php echo "Select Manufacturer" ?>: 
<select class="inputbox" name="manufacturer_id" onchange="order.submit()">
 <option value="product_list" ><?php echo $VM_LANG->_('PHPSHOP_SELECT') ?></option> 
            <!--<option value=""><?php echo _CMN_SELECT ?></option>-->
        <?php  		$query  = "SELECT distinct a.manufacturer_id,a.mf_name FROM #__{vm}_manufacturer AS a ";
		if (!empty( $category_id ) ) {
		    $query .= ", #__{vm}_product_category_xref AS d, "
		    . " #__{vm}_product AS b, "
		    . " #__{vm}_product_mf_xref AS c "
		    . " WHERE d.category_id='$category_id'"
		    . " AND d.product_id = b.product_id "
		    . " AND b.product_id = c.product_id AND c.manufacturer_id = a.manufacturer_id ";
		}
		$query .= "ORDER BY mf_name ASC";
		$db = new ps_DB;
		$db->query( $query );

		$res = $db->record;
		
			foreach ($res as $manufacturer) { 
					$selected = '';
					if( @$_REQUEST['manufacturer_id'] == $manufacturer->manufacturer_id ) {
							$selected = 'selected="selected"';      
					}
					echo "<option value=\"".$manufacturer->manufacturer_id ."\" $selected>". $manufacturer->mf_name ."</option>\n";

			} 
        ?>
</select><br/><br/>

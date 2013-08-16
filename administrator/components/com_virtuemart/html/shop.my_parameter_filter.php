<?php 
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); 

$bFirst = true;

$q = "SELECT ptp.* ".
	 "FROM  #__{vm}_product_category_xref AS pcx ".
	 "  RIGHT JOIN  #__{vm}_product_product_type_xref AS pptx ON pptx.product_id = pcx.product_id ".
	 "  RIGHT JOIN #__{vm}_product_type_parameter AS ptp ON ptp.product_type_id = pptx.product_type_id ".
	 "WHERE category_id = '$category_id' ".
	 "GROUP BY ptp.product_type_id ".
	 "ORDER BY ptp.parameter_list_order";
$db->query($q);

while ($db->next_record())
{
	// Выводим фильтры построчно
	if( $db->f('parameter_type') != 'V' )
		continue;

	if( $bFirst )
	{
		$bFirst = false;
		echo "<div class='module_vm_filter' style='padding-top:30px'>";		// Верхний отступ, потомучто флеш баннер перекрывает все
		echo '  '.$db->f('parameter_label').' <a href="" id="ingridient_checkbox_hide">(скрыть)</a><a href="" id="ingridient_checkbox_show" style="display:none">(показать)</a>';
		echo '<fieldset id="ingridient_fieldset">';
		?>
		<script type="text/javascript">
		jQuery(document).ready( function()
		{
			jQuery('#ingridient_checkbox_show').click( function()
			{
				jQuery.cookie('ingridient_form','showed');
				jQuery('#ingridient_checkbox_show').hide();
				jQuery('#ingridient_checkbox_hide').show();
				jQuery('#ingridient_fieldset').show('fast', function()
				{
					jQuery('#ingridient_form').show().css({opacity:0}).animate({'opacity':"1"},"fast");
				});
				return false;
			});
			jQuery('#ingridient_checkbox_hide').click( function()
			{
				jQuery.cookie('ingridient_form','hidded');
				jQuery('#ingridient_checkbox_show').show();
				jQuery('#ingridient_checkbox_hide').hide();
				jQuery('#ingridient_fieldset').hide('fast', function()
				{
					jQuery('#ingridient_form').animate({'opacity':"1"},"fast",function(){ jQuery('#ingridient_form').hide(); });
				});
				return false;
			});
			if( jQuery.cookie('ingridient_form') == "hidded" )
			{
				jQuery('#ingridient_checkbox_hide').trigger('click');
			}
		});
		</script>
		<?php
	}

	$parameter_values = $db->f('parameter_values');
	if( empty($parameter_values) )
		continue;
	$fields = explode(";", $parameter_values);
	
	$product_type_id_my = $db->f('product_type_id');
	$item_name = "product_type_{$product_type_id_my}_".$db->f("parameter_name");

//http://ddve.ru/index.php?page = shop.browse&option = com_virtuemart&Itemid = 64&product_type_id = 1&product_type_1_has_fish_comp = find_in_set_any&product_type_1_has_fish[]=%D0%A3%D0%B3%D0%BE%D1%80%D1%8C
	echo '<form id="ingridient_form" class="filter_form" action="'.
			$sess->url(
				$mm_action_url.basename($_SERVER['PHP_SELF']).
				"?page={$page}".
				"&category_id={$category_id}".
				"&pcat_id={$pcat_id}".
				""
			).'"
			method="POST">';
	echo '    <input type="hidden" name="product_type_id" value="'.$product_type_id_my.'">';
	echo '    <input type="hidden" name="'.$item_name.'_comp" value="find_in_set_any">';

	$selected_value = array();
	$get_item_value = vmGet($_REQUEST, $item_name, array());
	foreach($get_item_value as $value)
		$selected_value[$value] = 1;

	$fieldInColumn = ceil(count($fields)/3);

	$fieldCounter = 0;
	$isOpenDiv = false;
	foreach( $fields as $field )
	{
		if( $fieldCounter == 0 )
		{
			echo '<div style="width:30%; float:left">';
			$isOpenDiv = true;
		}

		echo '<div style="width:100%"><input type="checkbox" name="'.$item_name.'[]" value="'.$field.'" ';
		echo ($selected_value[$field]==1)? 'checked="checked"' : '';
		echo '> ';

		// HACK
		if (preg_match('/ролл дня/i', mb_convert_case($field, MB_CASE_LOWER, "UTF-8")))
			echo '<b style="font-size:1.0em">'.$field.'</b>';
		else
			echo $field;
		echo ' </div>';

		if( $fieldCounter == $fieldInColumn-1 )
		{
			echo '</div>';
			$isOpenDiv = false;
		}
		$fieldCounter = ($fieldCounter+1) % $fieldInColumn;
	}
	if( $isOpenDiv )
		echo '</div>';

	echo '<div style="width:10%; float:left"><input type="submit" class="submit" value="Выбрать"></div>';
	echo '</form>';
}
if( $bFirst == false )
{
	echo '<form class="filter_reset_form" action="'.
			$sess->url(
				$mm_action_url.basename($_SERVER['PHP_SELF']).
				"?page={$page}".
				"&category_id={$category_id}".
				"&pcat_id={$pcat_id}".
				""
			).'"
			method="POST">'.
		 '<input type="submit" class="submit" value="Показать все">'.
		 '</form>';
	echo '</fieldset>';
	echo "</div>";
}
return;



/*<form action="<?php echo $mm_action_url ?>index.php" method="post" name="addtocart" id="addtocart<?php echo str_replace('.','_',$i) ?>" class="addtocart_form" <?php if( $this->get_cfg( 'useAjaxCartActions', 1 ) && !$notify ) { echo 'onsubmit="handleAddToCart( this.id );return false;"'; } ?>>
    <?php echo $ps_product_attribute->show_quantity_box($product_id,$product_id); ?><br />
    <div class="browseProductOrder">
        <div class="browseProductOrderLink"><a href="javascript:void(0)" onclick="jQuery('#addtocart<?php echo str_replace('.','_',$i) ?>').submit(); return false;"><?php echo $button_lbl ?></a></div>
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
</form>
*/


$q  = "SELECT * FROM #__{vm}_product_type ";
$q .= "WHERE product_type_id='$product_type_id' ";
$q .= "AND product_type_publish='Y'";
$db->query($q);

$browsepage = $db->f("product_type_browsepage");

$vm_mainframe->setPageTitle( $VM_LANG->_('PHPSHOP_PARAMETER_SEARCH') );
$pathway[] = $vm_mainframe->vmPathwayItem( $VM_LANG->_('PHPSHOP_PARAMETER_SEARCH') );
$vm_mainframe->vmAppendPathway($pathway);

echo "<h2>".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH')."</h2>";

	if (!$db->next_record()) { // There is no published Product Type
		echo $VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_BAD_PRODUCT_TYPE');
	}
	else {
		echo "<table width=\"100%\" border=\"0\">\n<tr><td width=\"40%\">";
		echo $VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_IN_CATEGORY').": ".$db->f("product_type_name");
		// Reset form
		echo "</td><td align=\"center\">";
		echo "<form action=\"".$sess->url( $mm_action_url.basename($_SERVER['PHP_SELF']). "?page=shop.parameter_search_form&product_type_id=". $product_type_id ). "\" method=\"post\" name=\"reset\">\n";
		echo "<input type=\"submit\" class=\"button\" name=\"reset\" value=\"";
		echo $VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_RESET_FORM') ."\">\n</form>";
		echo "</td><td width=\"40%\">&nbsp;</td></tr></table>\n";

?>

<form action="<?php echo URL ?>index.php" method="post" name="attr_search">
<input type="hidden" name="option" value="com_virtuemart" />
<input type="hidden" name="page" value="shop.browse" />
<input type="hidden" name="product_type_id" value="<?php echo $product_type_id ?>" />
<input type="hidden" name="Itemid" value="<?php echo $sess->getShopItemid() ?>" />
<br />

<?php 
	$q  = "SELECT * FROM #__{vm}_product_type_parameter ";
	$q .= "WHERE product_type_id=$product_type_id ";
	$q .= "ORDER BY parameter_list_order";
	$db->query($q);
	
	?>
	<table width="100%" border="0" cellpadding="2" cellspacing="0">
	<?php
	/********************************************************
	** BrowsePage - You can use your tepmlate for searching:
	** 1) write file with html table (without tags <table> and </table>) and 
	**    take its name into variable browsepage in Product Type
	** 2) You can use this page from tag <!-- Default list of parameters - BEGIN --> to
	**    tag <!-- Default list of parameters - END --> and changed it.
	** 3) tag {product_type_<product_type_id>_<parameter_name>} will be replaced input field, or select field
	**    tag {product_type_<product_type_id>_<parameter_name>_comp} will be replaced comparison
	**        for this parameter. It is important for correct SQL question.
	**    tag {product_type_<product_type_id>_<parameter_name>_value} will be replaced value for this
	**        parameter (when you click on button "Change Parametes" in Browse page).
	********************************************************/
	if (!empty($browsepage)) { // show browsepage
		/** 
		*   Read the template file into a String variable.
		*
		* function read_file( $file, $defaultfile='') ***/
		$template = read_file( PAGEPATH."templates/".$browsepage.".php");
		//$template = str_replace( "{product_type_id}", $product_type_id, $template );	// If you need this, use it...
		while ($db->next_record()) {
			$item_name = "product_type_$product_type_id"."_".$db->f("parameter_name");
			$parameter_values=$db->f("parameter_values");
			$get_item_value = vmGet($_REQUEST, $item_name, "");
			$get_item_value_comp = vmGet($_REQUEST, $item_name."_comp", "");
			$parameter_type = $db->f("parameter_type");
			
			// Replace parameter value
			$template = str_replace( "{".$item_name."_value}", $get_item_value, $template );
				
			// comparison
			if (!empty($parameter_values) && $db->f("parameter_multiselect")=="Y") {
				if ($parameter_type == "V") { // type: Multiple Values
					// Multiple section List of values - comparison FIND_IN_SET
					$comp  = "<td width=\"10%\" height=\"2\" valign=\"top\" align=\"center\">\n";
					$comp .= "<select class=\"inputbox\" name=\"".$item_name."_comp\">\n";
					$comp .= "<option value=\"find_in_set_all\"".(($get_item_value_comp=="find_in_set_all")?" selected":"").">".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_FIND_IN_SET_ALL')."</option>\n";
					$comp .= "<option value=\"find_in_set_any\"".(($get_item_value_comp=="find_in_set_any")?" selected":"").">".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_FIND_IN_SET_ANY')."</option>\n";
					$comp .= "</select></td>";
				}
				else { // type: all other
					// Multiple section List of values - no comparison
					$comp = "<td><input type=\"hidden\" name=\"".$item_name."_comp\" value=\"in\" />\n</td>\n";
				}
			}
			else {
				switch( $parameter_type ) {
					case "C": // Char
						if (!empty($parameter_values)) { // List of values - no comparison
							$comp = "<input type=\"hidden\" name=\"".$item_name."_comp\" value=\"eq\" />\n";
							break;
						}
					case "I": // Integer
					case "F": // Float
					case "D": // Date & Time
					case "A": // Date
					case "M": // Time
						$comp  = "<select class=\"inputbox\" name=\"".$item_name."_comp\">\n";
						$comp .= "<option value=\"lt\"".(($get_item_value_comp=="lt")?" selected":"").">&lt;</option>\n";
						$comp .= "<option value=\"le\"".(($get_item_value_comp=="le")?" selected":"").">&lt;=</option>\n";
						$comp .= "<option value=\"eq\"".(($get_item_value_comp=="eq")?" selected":"").">=</option>\n";
						$comp .= "<option value=\"ge\"".((empty($get_item_value_comp)||$get_item_value_comp=="ge")?" selected":"").">&gt;=</option>\n";
						$comp .= "<option value=\"gt\"".(($get_item_value_comp=="gt")?" selected":"").">&gt;</option>\n";
						$comp .= "<option value=\"ne\"".(($get_item_value_comp=="ne")?" selected":"").">&lt;&gt;</option>\n";
						$comp .= "</select>\n";
						break;
					case "T": // Text
						if (!empty($parameter_values)) { // List of values - no comparison
							$comp = "<input type=\"hidden\" name=\"".$item_name."_comp\" value=\"texteq\" />\n";
							break;
						}
						$comp  = "<select class=\"inputbox\" name=\"".$item_name."_comp\">\n";
						$comp .= "<option value=\"like\"".(($get_item_value_comp=="like")?" selected":"").">".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_IS_LIKE')."</option>\n";
						$comp .= "<option value=\"notlike\"".(($get_item_value_comp=="notlike")?" selected":"").">".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_IS_NOT_LIKE')."</option>\n";
						$comp .= "<option value=\"fulltext\"".(($get_item_value_comp=="fulltext")?" selected":"").">".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_FULLTEXT')."</option>\n";
						$comp .= "</select>";
						break;
					case "S": // Short Text
					default:  // Default type Short Text
						if (!empty($parameter_values)) { // List of values - no comparison
							$comp = "<input type=\"hidden\" name=\"".$item_name."_comp\" value=\"texteq\" />\n";
							break;
						}
						$comp  = "<select class=\"inputbox\" name=\"".$item_name."_comp\">\n";
						$comp .= "<option value=\"like\"".(($get_item_value_comp=="like")?" selected":"").">".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_IS_LIKE')."</option>\n";
						$comp .= "<option value=\"notlike\"".(($get_item_value_comp=="notlike")?" selected":"").">".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_IS_NOT_LIKE')."</option>\n";
						$comp .= "</select></td>";
				}
			}
			// Relace parameter comparison
			$template = str_replace( "{".$item_name."_comp}", $comp, $template );
			
			// Parameter field
			if (!empty($parameter_values)) { // List of values
				$fields=explode(";",$parameter_values);
				$attr = "<select class=\"inputbox\" name=\"$item_name";
				if ($db->f("parameter_multiselect")=="Y") {
					$size = min(count($fields),6);
					$attr .= "[]\" multiple size=\"$size\">\n";
					$selected_value = array();
					$get_item_value = vmGet($_REQUEST, $item_name, array());
					foreach($get_item_value as $value) {
						$selected_value[$value] = 1;
					}
					foreach($fields as $field) {
						$attr .= "<option value=\"$field\"".(($selected_value[$field]==1) ? " selected>" : ">"). $field."</option>\n";
					}
				}
				else {
					$attr .= "\">\n";
					$attr .= "<option value=\"\">".$VM_LANG->_('PHPSHOP_SELECT')."</option>\n";
					foreach($fields as $field) {
						$attr .= "<option value=\"$field\"".(($get_item_value==$field) ? " selected>" : ">"). $field."</option>\n";
					}
				}
				$attr .= "</select>";
			}
			else { // Input field					
				switch( $parameter_type ) {
					case "I": // Integer
					case "F": // Float
					case "D": // Date & Time
					case "A": // Date
					case "M": // Time
						$attr = "<input type=\"text\" class=\"inputbox\"  name=\"$item_name\" value=\"$get_item_value\" size=\"20\" />";
						break;
					case "T": // Text
						$attr = "<textarea class=\"inputbox\" name=\"$item_name\" cols=\"35\" rows=\"6\" >$get_item_value</textarea>";
						break;
					case "C": // Char
						$attr = "<input type=\"text\" class=\"inputbox\"  name=\"$item_name\" value=\"$get_item_value\" size=\"5\" />";
						break;
					case "S": // Short Text
					default: // Default type Short Text
						$attr = "<input type=\"text\" class=\"inputbox\" name=\"$item_name\" value=\"$get_item_value\" size=\"50\" />";
				}
			}
			// Relace parameter
			$template = str_replace( "{".$item_name."}", $attr, $template );
		}
		echo $template;
	}
	else { // show default list of parameters
		echo "\n\n<!-- Default list of parameters - BEGIN -->\n";
		
		while ($db->next_record()) {
			$parameter_type = $db->f("parameter_type");
			if ($parameter_type!="B") {
				echo "<tr>\n  <td width=\"35%\" height=\"2\" valign=\"top\"><div align=\"right\"><strong>";
				echo $db->f("parameter_label");
			
				if ($db->f("parameter_description")) {
					echo "&nbsp;";
					echo mm_ToolTip($db->f("parameter_description"),$VM_LANG->_('PHPSHOP_PRODUCT_TYPE_PARAMETER_FORM_DESCRIPTION'));
				}
				echo "&nbsp;:</strong></div>\n  </td>\n";
				
				$parameter_values=$db->f("parameter_values");
				$item_name = "product_type_$product_type_id"."_".$db->f("parameter_name");
				$get_item_value = vmGet($_REQUEST, $item_name, "");
				$get_item_value_comp = vmGet($_REQUEST, $item_name."_comp", "");
			
				
				// comparison
				if (!empty($parameter_values) && $db->f("parameter_multiselect")=="Y") {
					if ($parameter_type == "V") { // type: Multiple Values
						// Multiple section List of values - comparison FIND_IN_SET
						echo "<td width=\"10%\" height=\"2\" valign=\"top\" align=\"center\">\n";
						echo "<select class=\"inputbox\" name=\"".$item_name."_comp\">\n";
						echo "<option value=\"find_in_set_all\"".(($get_item_value_comp=="find_in_set_all")?" selected":"").">".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_FIND_IN_SET_ALL')."</option>\n";
						echo "<option value=\"find_in_set_any\"".(($get_item_value_comp=="find_in_set_any")?" selected":"").">".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_FIND_IN_SET_ANY')."</option>\n";
						echo "</select></td>";
					}
					else { // type: all other
						// Multiple section List of values - no comparison
						echo "<td><input type=\"hidden\" name=\"".$item_name."_comp\" value=\"in\" />\n</td>\n";
					}
				}
				else {
					switch( $parameter_type ) {
						case "C": // Char
							if (!empty($parameter_values)) { // List of values - no comparison
								echo "<td><input type=\"hidden\" name=\"".$item_name."_comp\" value=\"eq\" />\n</td>\n";
								break;
							}
						case "I": // Integer
						case "F": // Float
						case "D": // Date & Time
						case "A": // Date
						case "M": // Time
							echo "<td width=\"10%\" height=\"2\" valign=\"top\" align=\"center\">\n";
							echo "<select class=\"inputbox\" name=\"".$item_name."_comp\">\n";
							echo "<option value=\"lt\"".(($get_item_value_comp=="lt")?" selected":"").">&lt;</option>\n";
							echo "<option value=\"le\"".(($get_item_value_comp=="le")?" selected":"").">&lt;=</option>\n";
							echo "<option value=\"eq\"".(($get_item_value_comp=="eq")?" selected":"").">=</option>\n";
							echo "<option value=\"ge\"".((empty($get_item_value_comp)||$get_item_value_comp=="ge")?" selected":"").">&gt;=</option>\n";
							echo "<option value=\"gt\"".(($get_item_value_comp=="gt")?" selected":"").">&gt;</option>\n";
							echo "<option value=\"ne\"".(($get_item_value_comp=="ne")?" selected":"").">&lt;&gt;</option>\n";
							echo "</select></td>";
							break;
						case "T": // Text
							if (!empty($parameter_values)) { // List of values - no comparison
								echo "<td><input type=\"hidden\" name=\"".$item_name."_comp\" value=\"texteq\" />\n</td>\n";
								break;
							}
							echo "<td width=\"10%\" height=\"2\" valign=\"top\" align=\"center\">\n";
							echo "<select class=\"inputbox\" name=\"".$item_name."_comp\">\n";
							echo "<option value=\"like\"".(($get_item_value_comp=="like")?" selected":"").">".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_IS_LIKE')."</option>\n";
							echo "<option value=\"notlike\"".(($get_item_value_comp=="notlike")?" selected":"").">".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_IS_NOT_LIKE')."</option>\n";
							echo "<option value=\"fulltext\"".(($get_item_value_comp=="fulltext")?" selected":"").">".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_FULLTEXT')."</option>\n";
							echo "</select></td>";
							break;
						case "V": // Multiple Value
							echo "<td><input type=\"hidden\" name=\"".$item_name."_comp\" value=\"find_in_set\" />\n</td>\n";
							break;
						case "S": // Short Text
						default:  // Default type Short Text
							if (!empty($parameter_values)) { // List of values - no comparison
								echo "<td><input type=\"hidden\" name=\"".$item_name."_comp\" value=\"texteq\" />\n</td>\n";
								break;
							}
							echo "<td width=\"10%\" height=\"2\" valign=\"top\" align=\"center\">\n";
							echo "<select class=\"inputbox\" name=\"".$item_name."_comp\">\n";
							echo "<option value=\"like\"".(($get_item_value_comp=="like")?" selected":"").">".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_IS_LIKE')."</option>\n";
							echo "<option value=\"notlike\"".(($get_item_value_comp=="notlike")?" selected":"").">".$VM_LANG->_('PHPSHOP_PARAMETER_SEARCH_IS_NOT_LIKE')."</option>\n";
							echo "</select></td>";
					}
				}
				
				if (!empty($parameter_values)) { // List of values
					$fields=explode(";",$parameter_values);
					echo "<td width=\"55%\" height=\"2\" valign=\"top\">\n";
					echo "<select class=\"inputbox\" name=\"$item_name";
					if ($db->f("parameter_multiselect")=="Y") {
						$size = min(count($fields),6);
						echo "[]\" multiple size=\"$size\">\n";
						$selected_value = array();
						$get_item_value = vmGet($_REQUEST, $item_name, array());
						foreach($get_item_value as $value) {
							$selected_value[$value] = 1;
						}
						foreach($fields as $field) {
							echo "<option value=\"$field\"".(($selected_value[$field]==1) ? " selected>" : ">"). $field."</option>\n";
						}
					}
					else {
						echo "\">\n";
						echo "<option value=\"\">".$VM_LANG->_('PHPSHOP_SELECT')."</option>\n";
						foreach($fields as $field) {
							echo "<option value=\"$field\"".(($get_item_value==$field) ? " selected>" : ">"). $field."</option>\n";
						}
					}
					echo "</select>";
				}
				else { // Input field					
					echo "<td width=\"55%\" height=\"2\">\n";
					switch( $parameter_type ) {
						case "I": // Integer
						case "F": // Float
						case "D": // Date & Time
						case "A": // Date
						case "M": // Time
							echo "<input type=\"text\" class=\"inputbox\"  name=\"$item_name\" value=\"$get_item_value\" size=\"20\" />";
							break;
						case "T": // Text
							echo "<textarea class=\"inputbox\" name=\"$item_name\" cols=\"35\" rows=\"6\" >$get_item_value</textarea>";
							break;
						case "C": // Char
							echo "<input type=\"text\" class=\"inputbox\"  name=\"$item_name\" value=\"$get_item_value\" size=\"5\" />";
							break;
						case "S": // Short Text
						default: // Default type Short Text
							echo "<input type=\"text\" class=\"inputbox\" name=\"$item_name\" value=\"$get_item_value\" size=\"50\" />";
					}
				}
				echo " ".$db->f("parameter_unit");
				switch( $parameter_type ) {
					case "D": // Date & Time
						echo " (".$VM_LANG->_('PHPSHOP_PRODUCT_TYPE_PARAMETER_FORM_TYPE_DATE_FORMAT')." ";
						echo $VM_LANG->_('PHPSHOP_PRODUCT_TYPE_PARAMETER_FORM_TYPE_TIME_FORMAT').")";
						break;
					case "A": // Date
						echo " (".$VM_LANG->_('PHPSHOP_PRODUCT_TYPE_PARAMETER_FORM_TYPE_DATE_FORMAT').")";
						break;
					case "M": // Time
						echo " (".$VM_LANG->_('PHPSHOP_PRODUCT_TYPE_PARAMETER_FORM_TYPE_TIME_FORMAT').")";
						break;
				}
			}
			else { // Break line (type == "B")
				echo "<tr>\n  <td colspan=\"3\" height=\"2\" ><hr>";
			}
			echo "  </td>\n</tr>";
			
		}
		echo "\n<!-- Default list of parameters - END -->\n\n";		
	}
	
	// Add search according to price:	
	$item_name = "price";
	$get_item_value = vmGet($_REQUEST, $item_name, "");
	$get_item_value_comp = vmGet($_REQUEST, $item_name."_comp", "");
	
	echo "<tr>\n  <td width=\"35%\" height=\"2\" valign=\"top\"><div align=\"right\"><strong>";
	echo $VM_LANG->_('PHPSHOP_CART_PRICE')."&nbsp;:</strong></div>\n  </td>\n";
	// comparison
	echo "<td width=\"10%\" height=\"2\" valign=\"top\" align=\"center\">\n";
	echo "<select class=\"inputbox\" name=\"price_comp\">";
	echo "<option value=\"lt\"".(($get_item_value_comp=="lt")?" selected":"").">&lt;</option>\n";
	echo "<option value=\"le\"".((empty($get_item_value_comp)||$get_item_value_comp=="le")?" selected":"").">&lt;=</option>\n";
	echo "<option value=\"eq\"".(($get_item_value_comp=="eq")?" selected":"").">=</option>\n";
	echo "<option value=\"ge\"".(($get_item_value_comp=="ge")?" selected":"").">&gt;=</option>\n";
	echo "<option value=\"gt\"".(($get_item_value_comp=="gt")?" selected":"").">&gt;</option>\n";
	echo "<option value=\"ne\"".(($get_item_value_comp=="ne")?" selected":"").">&lt;&gt;</option>\n";
	echo "</select></td>";
	// input text
	echo "\n<td> <input type=\"text\" class=\"inputbox\"  name=\"price\" value=\"$get_item_value\" size=\"20\" /></td>\n</tr>";	
	
	// Search Button
?>	
	<tr><td colspan="3" height="2" >&nbsp;</td></tr>
	<tr><td colspan="3" height="2" ><div align="center">
		<input type="submit" class="button" name="search" value="<?php echo $VM_LANG->_('PHPSHOP_SEARCH_TITLE') ?>">
		</div></td>
	</tr>
</table>
<?php
  } // end - There is a published Product Type
/** Changed Product Type - End */
?>
</form>

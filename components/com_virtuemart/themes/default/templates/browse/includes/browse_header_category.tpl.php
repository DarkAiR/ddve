<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
mm_showMyFileName(__FILE__);?>

<?php
    // DarkAiR
	/*
	echo '<h3>';
    echo $browsepage_lbl;
    echo '<br/>';

	if( $this->get_cfg( 'showFeedIcon', 1 ) && (VM_FEED_ENABLED == 1) )
	{
		echo '<a href="index.php?option='.VM_COMPONENT_NAME.'&amp;page=shop.feed&amp;category_id='.$category_id.'" title="'.$VM_LANG->_('VM_FEED_SUBSCRIBE_TOCATEGORY_TITLE').'">';
		echo '<img src="'.VM_THEMEURL.'images/feed-icon-14x14.png" align="middle" alt="feed" border="0"/></a>';
	}
	echo '</h3>';
	*/

	echo '<div style="text-align:left;">';
	echo $navigation_childlist;
	echo '</div>';

/*	if( trim(str_replace( "<br />", "" , $desc)) != "" )
	{
		echo '<div style="width:100%;float:left;">';
		echo $desc;
		echo '</div>';
		echo '<br class="clr" /><br />';
	}
*/
?>
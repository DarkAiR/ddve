<?php
/**
* @Copyright Copyright (C) 2010- calendarium
* @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
**/
defined( '_JEXEC' ) or die( 'Restricted access' );
JHTML::stylesheet( 'jscal2.css', 'modules/mod_jscal2_for_joomla/src/css/' );
JHTML::stylesheet( 'border-radius.css', 'modules/mod_jscal2_for_joomla/src/css/' );
if ($compact) JHTML::stylesheet( 'reduce-spacing.css', 'modules/mod_jscal2_for_joomla/src/css/' );
if ($theme!='bare') JHTML::stylesheet( $theme.'.css', 'modules/mod_jscal2_for_joomla/src/css/'.$theme.'/' );
?>

<?php if ($time==1) $time=true; ?>

<script src="modules/mod_jscal2_for_joomla/src/js/jscal2.js"></script>

<script src="modules/mod_jscal2_for_joomla/src/js/lang/<?php echo $lang ?>.js"></script>

<div align="center"><div id="cont"></div></div>
<script type="text/javascript">
	var LEFT_CAL = Calendar.setup({
		cont: "cont",
		<?php if ($num_week) echo 'weekNumbers: true,'; ?>
		<?php if ($time) echo 'showTime: '.$time.','; ?>
		<?php if ($time) echo 'timePos: "'.$time_pos.'",'; ?>
		<?php if (!$animation) echo 'animation: false,'; ?>
		selectionType: Calendar.SEL_MULTIPLE                 
	})
</script>
		  

<?php
/**
* @Copyright Copyright (C) 2010- BMForce
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined( '_JEXEC' ) or die( 'Restricted access' );
if ($params->get("CSSlist")) JHTML::stylesheet( $params->get("CSSlist"), 'modules/mod_jalendar/css/' );
else 
{
?>
	<style type="text/css">
	<?php
	echo $css;
	?>
	</style>
<?php
}
JHTML::_('behavior.mootools');
if ($params->get("use_ajax"))
{
?>
	<script type="text/javascript" charset='utf-8' src="modules/mod_jalendar/js/jal.js">
	</script>
	<script type="text/javascript" charset='utf-8'>
	var server_url = '<?php echo $rooturi; ?>'; 
	</script>
<?php
}
echo $cont; 

?>



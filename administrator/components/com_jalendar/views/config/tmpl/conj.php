<?php 
/**
* @Copyright Copyright (C) 2010- BMForce
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die(); ?>

<form action="index.php" method="post" name="adminForm">


<div id="editcell">
    <table class="adminlist">
    <thead>
        <tr>
            <th width="5">
                <?php echo JText::_( 'ID' ); ?>
            </th>
                <th width="20">
    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->articledates ); ?>);" />
</th>
            <th>
                <?php echo JText::_( 'Title' ); ?>
            </th>
			<th>
                <?php echo JText::_( 'ID article' ); ?>
            </th>
			<th>
                <?php echo JText::_( 'Date' ); ?>
            </th>
			<th>
                <?php echo JText::_( 'Type' ); ?>
            </th>
          
        </tr>
    </thead>
    <?php
    $k = 0;
    for ($i=0, $n=count( $this->articledates ); $i < $n; $i++)
    {
        $articledate =& $this->articledates[$i];
        ?>
        <tr class="<?php echo "row$k"; ?>">
            <td>
                <?php echo $articledate->id; ?>
            </td>
			<td>
			<?php $checked    = JHTML::_( 'grid.id', $i, $articledate->id ); echo $checked; ?>
			</td>
			 <td>
           <?php echo $articledate->title; ?>
            </td>
            <td>
           <?php echo $articledate->id_article; ?>
            </td>
			      <td>
           <?php echo $articledate->date; ?>
            </td>
			      <td>
           <?php echo $articledate->type; ?>
            </td>
            
        </tr>
        <?php
        $k = 1 - $k;
    }
    ?>
	<tfoot>
	<tr>
	<td colspan="15">
	<?php echo $this->pagination->getListFooter(); ?>
	</td>
	</tr>
	</tfoot>
    </table>
</div>

<input type="hidden" name="option" value="com_jalendar" />
<input type="hidden" name="task" value="conj" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="conj" />

</form>
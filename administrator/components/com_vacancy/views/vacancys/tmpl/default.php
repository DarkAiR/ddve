<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm">
<div id="editcell">
    <table class="adminlist">
    <thead>
        <tr>
            <th width="5"><?php echo JText::_( 'ID' ); ?></th>
            <th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" /></th>          
            <th><?php echo JText::_( 'Title' ); ?></th>
            <th width="5%" class="title" nowrap="nowrap">
                <?php echo JHTML::_('grid.sort',   'Published', 'cd.published', 'ASC', 'ordering' ); ?>
            </th>
            <th nowrap="nowrap" width="8%">
                <?php echo JHTML::_('grid.sort',   'Order by', 'cd.ordering', 'ASC', 'ordering' ); ?>
                <?php echo JHTML::_('grid.order',  $this->items ); ?>
            </th>
        </tr>
    </thead>
    <?php
    $k = 0;
    for ($i=0, $n=count($this->items); $i < $n; $i++)
    {
        $row = &$this->items[$i];
        $checked    = JHTML::_('grid.id', $i, $row->id );
        $published  = JHTML::_('grid.published', $row, $i );
        $link       = JRoute::_( 'index.php?option=com_vacancy&controller=vacancy&task=edit&cid[]='. $row->id );
        ?>
        <tr class="<?php echo "row$k"; ?>">
            <td><?php echo $this->pageNav->getRowOffset( $i ); ?></td>
            <td><?php echo $checked; ?></td>
            <td><a href="<?php echo $link; ?>"><?php echo $row->title; ?></a></td>
            <td align="center"><?php echo $published;?></td>
            <td class="order">
                <span><?php echo $this->pageNav->orderUpIcon( $i ); ?></span>
                <span><?php echo $this->pageNav->orderDownIcon( $i, $n ); ?></span>
                <input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" class="text_area" style="text-align: center" />
            </td>
        </tr>
        <?php
        $k = 1 - $k;
    }
    ?>
    </table>
</div>

<input type="hidden" name="option" value="com_vacancy" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="vacancy" />
</form>

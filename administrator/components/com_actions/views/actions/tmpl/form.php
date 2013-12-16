<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php
    $editor = &JFactory::getEditor();
?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col200">
    <fieldset class="adminform">
        <legend><?php echo JText::_( 'Details' ); ?></legend>

        <table class="admintable" width="100%">
        <tr>
            <td width="100" align="right" class="key">
                <label for="title"><?php echo JText::_( 'Title' ); ?>:</label>
            </td>
            <td>
                <input class="text_area" type="text"
                       name="title" id="title" size="64" maxlength="250"
                       value="<?php echo $this->action->title;?>" />
            </td>
        </tr>

        <tr>
            <td class="key">
                <?php echo JText::_( 'Published' ); ?>:
            </td>
            <td>
                <?php echo $this->action->published; ?>
                <input type="hidden" name="published" value="<?php echo $this->action->published; ?>" />
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="rollday"><?php echo JText::_( 'RollDay' ); ?>:</label>
            </td>
            <td>
                <input type="checkbox"
                       name="rollday" id="rollday"
                        <?php
                            if( $this->action->rollday )
                                echo 'checked=checked';
                        ?> />
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="text"><?php echo JText::_( 'Text' ); ?>:</label>
            </td>
            <td>
                <?php
                    //<textarea name="text" id="text" rows="10" cols="45" class="inputbox"><?php echo $this->action->text; ?></textarea>
                ?>
                <?php
                    // parameters : areaname, content, width, height, cols, rows
                    echo $editor->display( 'text',  $this->action->text , '80%', '300', '75', '20' ) ;
                ?>
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="smalltext"><?php echo JText::_( 'SmallText' ); ?>:</label>
            </td>
            <td>
                <textarea name="smalltext" id="smalltext" rows="10" cols="90" class="inputbox"><?php echo $this->action->smalltext; ?></textarea>
                <?php
                    // parameters : areaname, content, width, height, cols, rows
                    //echo $editor->display( 'smalltext',  $this->action->smalltext , '80%', '300', '75', '20' ) ;
                ?>
            </td>
        </tr>

    </table>
    </fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_actions" />
<input type="hidden" name="id" value="<?php echo $this->action->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="actions" />
</form>

<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
    <fieldset class="adminform">
        <legend><?php echo JText::_( 'Details' ); ?></legend>

        <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="title"><?php echo JText::_( 'Title' ); ?>:</label>
            </td>
            <td>
                <input class="text_area" type="text"
                       name="title" id="title" size="32" maxlength="250"
                       value="<?php echo $this->vacancy->title;?>" />
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="required"><?php echo JText::_( 'Required' ); ?>:</label>
            </td>
            <td>
                <!--textarea name="required" id="required" rows="3" cols="45" class="inputbox"><?php echo $this->vacancy->required; ?></textarea-->
<?php
    $editor = &JFactory::getEditor();
    // parameters : areaname, content, width, height, cols, rows
    echo $editor->display( 'required',  $this->vacancy->required , '100%', '550', '75', '20' ) ;
?>
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="responsibility"><?php echo JText::_( 'Responsibility' ); ?>:</label>
            </td>
            <td>
                <textarea name="responsibility" id="responsibility" rows="3" cols="45" class="inputbox"><?php echo $this->vacancy->responsibility; ?></textarea>
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="conditions"><?php echo JText::_( 'Conditions' ); ?>:</label>
            </td>
            <td>
                <textarea name="conditions" id="conditions" rows="3" cols="45" class="inputbox"><?php echo $this->vacancy->conditions; ?></textarea>
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="phone"><?php echo JText::_( 'Phone' ); ?>:</label>
            </td>
            <td>
                <input class="text_area" type="text"
                       name="phone" id="phone" size="32" maxlength="250"
                       value="<?php echo $this->vacancy->phone;?>" />
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="info"><?php echo JText::_( 'Info' ); ?>:</label>
            </td>
            <td>
                <textarea name="info" id="info" rows="3" cols="45" class="inputbox"><?php echo $this->vacancy->info; ?></textarea>
            </td>
        </tr>

    </table>
    </fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_vacancy" />
<input type="hidden" name="id" value="<?php echo $this->vacancy->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="vacancy" />
</form>

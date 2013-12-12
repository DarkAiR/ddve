<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col200">
    <fieldset class="adminform">
        <legend><?php echo JText::_( 'Details' ); ?></legend>

        <table class="admintable" width="100%">
        <tr>
            <td class="key">
                <?php echo JText::_( 'Published' ); ?>:
            </td>
            <td>
                <?php echo $this->deliverycondition->published; ?>
                <input type="hidden" name="published" value="<?php echo $this->deliverycondition->published; ?>" />
            </td>
        </tr>


        <tr>
            <td width="100" align="right" class="key">
                <label for="text"><?php echo JText::_( 'Text' ); ?>:</label>
            </td>
            <td>
                <textarea name="text" id="text" rows="10" cols="45" class="inputbox"><?php echo $this->deliverycondition->text; ?></textarea>
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="summ"><?php echo JText::_( 'Summ' ); ?>:</label>
            </td>
            <td>
                <input class="text_area" type="text"
                       name="summ" id="summ" size="64" maxlength="250"
                       value="<?php echo $this->deliverycondition->summ;?>" />
            </td>
        </tr>

    </table>
    </fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_deliverycondition" />
<input type="hidden" name="id" value="<?php echo $this->deliverycondition->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="deliverycondition" />
</form>

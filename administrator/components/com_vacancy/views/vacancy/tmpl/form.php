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
                       value="<?php echo $this->vacancy->title;?>" />
            </td>
        </tr>

        <tr>
            <td class="key">
                <?php echo JText::_( 'Published' ); ?>:
            </td>
            <td>
                <?php echo $this->vacancy->published; ?>
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="required"><?php echo JText::_( 'Required' ); ?>:</label>
            </td>
            <td>
                <!--textarea name="required" id="required" rows="10" cols="45" class="inputbox"><?php echo $this->vacancy->required; ?></textarea-->
                <?php
                    // parameters : areaname, content, width, height, cols, rows
                    echo $editor->display( 'required',  $this->vacancy->required , '80%', '300', '75', '20' ) ;
                ?>
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="skills"><?php echo JText::_( 'Skills' ); ?>:</label>
            </td>
            <td>
                <!--textarea name="skills" id="skills" rows="3" cols="45" class="inputbox"><?php echo $this->vacancy->skills; ?></textarea-->
                <?php
                    // parameters : areaname, content, width, height, cols, rows
                    echo $editor->display( 'skills',  $this->vacancy->skills , '80%', '300', '75', '20' ) ;
                ?>
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="responsibility"><?php echo JText::_( 'Responsibility' ); ?>:</label>
            </td>
            <td>
                <!--textarea name="responsibility" id="responsibility" rows="3" cols="45" class="inputbox"><?php echo $this->vacancy->responsibility; ?></textarea-->
                <?php
                    // parameters : areaname, content, width, height, cols, rows
                    echo $editor->display( 'responsibility',  $this->vacancy->responsibility , '80%', '300', '75', '20' ) ;
                ?>
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="conditions"><?php echo JText::_( 'Conditions' ); ?>:</label>
            </td>
            <td>
                <!--textarea name="conditions" id="conditions" rows="3" cols="45" class="inputbox"><?php echo $this->vacancy->conditions; ?></textarea-->
                <?php
                    // parameters : areaname, content, width, height, cols, rows
                    echo $editor->display( 'conditions',  $this->vacancy->conditions , '80%', '300', '75', '20' ) ;
                ?>
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="info"><?php echo JText::_( 'Info' ); ?>:</label>
            </td>
            <td>
                <!--textarea name="info" id="info" rows="3" cols="45" class="inputbox"><?php echo $this->vacancy->info; ?></textarea-->
                <?php
                    // parameters : areaname, content, width, height, cols, rows
                    echo $editor->display( 'info',  $this->vacancy->info , '80%', '300', '75', '20' ) ;
                ?>
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="address"><?php echo JText::_( 'Address' ); ?>:</label>
            </td>
            <td>
                <input class="text_area" type="text"
                       name="address" id="address" size="64" maxlength="250"
                       value="<?php echo $this->vacancy->address;?>" />
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="phone"><?php echo JText::_( 'Phone' ); ?>:</label>
            </td>
            <td>
                <input class="text_area" type="text"
                       name="phone" id="phone" size="64" maxlength="250"
                       value="<?php echo $this->vacancy->phone;?>" />
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

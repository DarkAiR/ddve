<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php
    $editor = &JFactory::getEditor();

    $config =& JFactory::getConfig();
    $date =& JFactory::getDate($this->news->date);
    $date->setOffset($config->getValue('config.offset'));
    $date = $date->toFormat();
?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
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
                       value="<?php echo $this->news->title;?>" />
            </td>
        </tr>

        <tr>
            <td class="key">
                <?php echo JText::_( 'Published' ); ?>:
            </td>
            <td>
                <?php echo $this->news->published; ?>
                <input type="hidden" name="published" value="<?php echo $this->news->published; ?>" />
            </td>
        </tr>

        <tr>
            <td class="key">
                <label for="date">
                    <?php echo JText::_( 'Date' ); ?>:
                </label>
            </td>
            <td>
                <?php echo JHTML::_('calendar', $date, 'date', 'date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'25',  'maxlength'=>'19')); ?>
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="mainimage"><?php echo JText::_( 'MainImage' ); ?>:</label>
            </td>
            <td>
                <input id="mainimage" type="file" name="mainimage">
                <?php
                    if (!empty($this->news->mainimage))
                    {?>
                        <div style='padding-top:5px'>
                        <a target="_blank" href="<?= $this->news->mainimage ?>">
                            <img style="max-width:120px; max-height:120px" src="<?= $this->news->mainimage ?>" alt="">
                        </a>
                        </div>
                    <?}
                ?>
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="introtext"><?php echo JText::_( 'IntroText' ); ?>:</label>
            </td>
            <td>
                <?php
                    // parameters : areaname, content, width, height, cols, rows
                    echo $editor->display( 'introtext',  $this->news->introtext , '80%', '300', '75', '20' ) ;
                ?>
            </td>
        </tr>

        <tr>
            <td width="100" align="right" class="key">
                <label for="fulltext"><?php echo JText::_( 'FullText' ); ?>:</label>
            </td>
            <td>
                <?php
                    // parameters : areaname, content, width, height, cols, rows
                    echo $editor->display( 'fulltext',  $this->news->fulltext , '80%', '300', '75', '20' ) ;
                ?>
            </td>
        </tr>

    </table>
    </fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_news" />
<input type="hidden" name="id" value="<?php echo $this->news->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="news" />
</form>
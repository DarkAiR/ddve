<?php 
/**
* @Copyright Copyright (C) 2010- BMForce
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
    <fieldset class="adminform">
        <legend></legend>
        <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="field">
                    <?php echo JText::_( 'Article' ); ?>:
                </label>
            </td>
            <td>
               <select name="articlelist" id="articlelist" size="1" class="inputbox" style="width: 400px;">
			   <?php for($i = 0; $i < count($this->allarticles); $i++)
				{ ?>
					<option value="<?php echo $this->allarticles[$i]->id ?>" <?php if ($this->allarticles[$i]->id==$this->articledate->id_article) echo 'selected="selected"'; ?>><?php echo $this->allarticles[$i]->id.': '.$this->allarticles[$i]->title ?></option>
			<?php  } ?>
			   </select> 
            </td>

        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="field">
                    <?php echo JText::_( 'Date' ); ?>:
                </label>
            </td>
            <td>
			<input name="adate" id="adate" type="text" style="width:100px;" value="<?php echo $this->articledate->date;?>" />
		<input type="reset" class="button" value="..." onclick="return showCalendar('adate','%Y-%m-%d');" />

            </td>

        </tr>
		  <tr>
            <td width="100" align="right" class="key">
                <label for="field">
                    <?php echo JText::_( 'Type' ); ?>:
                </label>
            </td>
            <td>
				<?php
				$repeat = array(
				JHTML::_('select.option',  '0', JText::_( 'No repeat' ) ),
				JHTML::_('select.option',  '1', JText::_( 'Repeat each year' ))
				);

				echo JHTML::_('select.genericlist',   $repeat, 'typedate', 'size="2" class="inputbox"', 'value', 'text', empty($this->articledate->type)?0:$this->articledate->type );
				?>

            </td>

        </tr>
    </table>

    </fieldset>
</div>

<div class="clr"></div>

<input type="hidden" name="option" value="com_jalendar" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="" />
<input type="hidden" name="jid" value="<?php echo $this->articledate->id;?>" />
</form>

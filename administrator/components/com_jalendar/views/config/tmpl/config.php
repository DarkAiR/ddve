<?php
/**
* @Copyright Copyright (C) 2010- BMForce
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">

<div id="config-document">
	<div id="page-main">
    <fieldset class="adminform">
     
        <table class="admintable" width="50%" style="float:left">
		
		     <tr>
            <td width="140" align="right" class="key">
                    <?php echo JText::_( "Type view" ); ?>: 
            </td>
            <td colspan="3">
				<?php echo $this->type; ?>
            </td>
        </tr>
		
	
		       <tr>
            <td>
                   <?php echo JText::_( "General setting" ); ?> 
            </td>
        </tr>
		
			         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "Show Uncategorised articles" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->uncat; ?>
            </td>
        </tr>
		
		         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "ID sections" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->id_section; ?>
            </td>
        </tr>
       
        <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "ID categories" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->id_category; ?>
            </td>
        </tr>
       
	         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "ID articles (black list)" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->id_article; ?>
            </td>
        </tr>
		
		      <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "Articles on page" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->a_page; ?>
            </td>
        </tr>
		
		
		       <tr>
            <td>
                   <?php echo JText::_( 'Setting for view "Date, time and title"' ); ?> 
            </td>
        </tr>
		
		
		      <tr>
            <td width="140" align="right" class="key">
                    <?php echo JText::_( "Date and time" ); ?>: 
            </td>
            <td colspan="3">
			<?php echo $this->pldate; ?>
            </td>
        </tr>
		
		       <tr>
            <td>
                   <?php echo JText::_( 'Setting for view "Standard view"'); ?> 
            </td>
        </tr>
		
		
						         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "Title Linkable" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->title_link; ?>
            </td>
        </tr>
		
			         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "Section Name" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->section_v; ?>
            </td>
        </tr>	
		
				         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "Section Title Linkable" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->section_link ; ?>
            </td>
        </tr>
		
		
					         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "Category Name" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->category_v; ?>
            </td>
        </tr>
		
		
					         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "Category Title Linkable" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->category_link; ?>
            </td>
        </tr>
		
		
		
			         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "Icons" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->icon_v; ?>
            </td>
        </tr>
		
			         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "PDF Icon" ); ?>:
               
            </td>
            <td colspan="3">
			<?php echo $this->pdf_icon; ?>
            </td>
        </tr>
		
			         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "E-mail icon" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->email_icon; ?>
            </td>
        </tr>
		
			         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "Print Icon" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->print_icon; ?>
            </td>
        </tr>
		

		
		
			
		
		
					         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "Author Name" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->username_v; ?>
            </td>
        </tr>
		
					         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "Type Name" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->username_t; ?>
            </td>
        </tr>
		
					         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "Created Date and Time" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->crdate_v; ?>
            </td>
        </tr>
		
					         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "Modified Date and Time" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->mdate_v; ?>
            </td>
        </tr>
		
					         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "ReadMore... Link" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->readmore_v; ?>
            </td>
        </tr>
		
		       <tr>
            <td>
                   <a style="text-decoration: underline;" href="index.php?option=com_jalendar&view=config&layout=conj&task=conj"><?php echo JText::_( "LINKAGE ARTICLES AND DATES" ); ?></a>
            </td>
        </tr>
		
				         <tr>
            <td align="right" class="key">
             
                    <?php echo JText::_( "Show" ); ?>:
               
            </td>
            <td colspan="3">
				<?php echo $this->a_type; ?>
            </td>
        </tr>


       
</table>
</fieldset>
</div>


</div>



<input type="hidden" name="option" value="com_jalendar" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="config" />
</form>

<?php // no direct access
defined('_JEXEC') or die('Restricted access');

$canEdit = ($this->user->authorize('com_content', 'edit', 'content', 'all') || $this->user->authorize('com_content', 'edit', 'content', 'own'));
$pageSuff = $this->escape($this->params->get('pageclass_sfx'));

if ($this->params->get('show_page_title', 1) && $this->params->get('page_title') != $this->article->title)
{
    echo '<div class="componentheading'.$pageSuff.'">';
    echo $this->escape($this->params->get('page_title'));
    echo '</div>';
}

if ($canEdit || $this->params->get('show_title') || $this->params->get('show_pdf_icon') || $this->params->get('show_print_icon') || $this->params->get('show_email_icon'))
{
    echo '<table class="contentpaneopen'.$pageSuff.'">';
    echo '<tr>';
        if ($this->params->get('show_title'))
        {
            echo '<td class="contentheading'.$pageSuff.'" width="100%">';
                if ($this->params->get('link_titles') && $this->article->readmore_link != '')
                {
                    echo '<a href="'.$this->article->readmore_link.'" class="contentpagetitle'.$pageSuff.'">';
                    echo $this->escape($this->article->title);
                    echo '</a>';
                }
                else
                {
                    echo $this->escape($this->article->title);
                }
            echo '</td>';
        }
        if (!$this->print)
        {
            if ($this->params->get('show_pdf_icon'))
            {
                echo '<td align="right" width="100%" class="buttonheading">';
                echo JHTML::_('icon.pdf',  $this->article, $this->params, $this->access);
                echo '</td>';
            }
            if ( $this->params->get( 'show_print_icon' ))
            {
                echo '<td align="right" width="100%" class="buttonheading">';
                echo JHTML::_('icon.print_popup',  $this->article, $this->params, $this->access);
                echo '</td>';
            }
            if ($this->params->get('show_email_icon'))
            {
                echo '<td align="right" width="100%" class="buttonheading">';
                echo JHTML::_('icon.email',  $this->article, $this->params, $this->access);
                echo '</td>';
            }
            if ($canEdit)
            {
                echo '<td align="right" width="100%" class="buttonheading">';
                echo JHTML::_('icon.edit', $this->article, $this->params, $this->access);
                echo '</td>';
            }
        }
        else
        {
            echo '<td align="right" width="100%" class="buttonheading">';
            echo JHTML::_('icon.print_screen',  $this->article, $this->params, $this->access);
            echo '</td>';
        }
    echo '</tr>';
    echo '</table>';
}

echo '<div class="content-indent">';
    if (!$this->params->get('show_intro'))
        echo $this->article->event->afterDisplayTitle;

    echo $this->article->event->beforeDisplayContent;

    echo '<table class="contentpaneopen'.$pageSuff.'">';
        if (($this->params->get('show_section') && $this->article->sectionid) || ($this->params->get('show_category') && $this->article->catid))
        {
            echo '<tr>';
            echo '<td>';
                if ($this->params->get('show_section') && $this->article->sectionid && isset($this->article->section))
                {
                    echo '<span>';
                    if ($this->params->get('link_section'))
                        echo '<a href="'.JRoute::_(ContentHelperRoute::getSectionRoute($this->article->sectionid)).'">';
                    echo $this->escape($this->article->section);
                    if ($this->params->get('link_section'))
                        echo '</a>';
                    if ($this->params->get('show_category'))
                        echo ' - ';
                    echo '</span>';
                }
                if ($this->params->get('show_category') && $this->article->catid)
                {
                    echo '<span>';
                    if ($this->params->get('link_category'))
                        echo '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->article->catslug, $this->article->sectionid)).'">';
                    echo $this->escape($this->article->category);
                    if ($this->params->get('link_category'))
                        echo '</a>';
                    echo '</span>';
                }
            echo '</td>';
            echo '</tr>';
        }

        if (($this->params->get('show_author')) && ($this->article->author != ""))
        {
            echo '<tr>';
            echo '<td valign="top">';
                echo '<span class="small">';
                    JText::printf( 'Written by', ($this->escape($this->article->created_by_alias) ? $this->escape($this->article->created_by_alias) : $this->escape($this->article->author)) );
                echo '</span>';
                echo '&nbsp;&nbsp;';
            echo '</td>';
            echo '</tr>';
        }

        if ($this->params->get('show_create_date'))
        {
            echo '<tr>';
            echo '<td valign="top" class="createdate">';
                echo JHTML::_('date', $this->article->created, JText::_('DATE_FORMAT_LC2'));
            echo '</td>';
            echo '</tr>';
        }

        if ($this->params->get('show_url') && $this->article->urls)
        {
            echo '<tr>';
            echo '<td valign="top">';
                echo '<a href="http://'.$this->article->urls.'" target="_blank">'.$this->escape($this->article->urls).'</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '<tr>';
        echo '<td valign="top">';
            if (isset ($this->article->toc))
                echo $this->article->toc;

            echo $this->article->text;
        echo '</td>';
        echo '</tr>';

        if ( intval($this->article->modified) !=0 && $this->params->get('show_modify_date'))
        {
            echo '<tr>';
            echo '<td class="modifydate">';
                echo JText::sprintf('LAST_UPDATED2', JHTML::_('date', $this->article->modified, JText::_('DATE_FORMAT_LC2')));
            echo '</td>';
            echo '</tr>';
        }
    echo '</table>';
echo '</div>';

if (!empty($this->article->signature))
{
    echo '<div class="signature">';
    echo $this->article->signature;
    echo '</div>';
}

echo '<span class="article_separator">&nbsp;</span>';
echo $this->article->event->afterDisplayContent;
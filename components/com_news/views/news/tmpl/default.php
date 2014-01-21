<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');

$pageSuff = '_news';//$this->escape($this->params->get('pageclass_sfx'));
$innerHeight = 50;
?>

<form action="<?php echo JRoute::_('index.php?option=com_news'); ?>" method="post" name="adminForm">

<script type="text/javascript">
    jQuery(document).ready( function()
    {
        jQuery('.content<?= $pageSuff ?>').each( function(index, el)
        {
            var self = jQuery(this);
            var showmore = self.find('.showmore<?= $pageSuff ?>');
            var hidemore = self.find('.hidemore<?= $pageSuff ?>');
            var text = self.find('.text<?= $pageSuff ?>');
            var textInner = self.find('.text_inner<?= $pageSuff ?>');
            var textBg = self.find('.text_bg<?= $pageSuff ?>');

            if (textInner.height() > <?= $innerHeight ?>)
                showmore.css({'display':'inline-block'});
            else
                textBg.hide();

            showmore.click( function()
            {
                showmore.css({'display':'none'});
                hidemore.css({'display':'inline-block'});
                textBg.hide();

                var h = textInner.height();
                if (h < <?= $innerHeight ?>)
                    h = <?= $innerHeight ?>;
                text.stop().animate({'max-height':h}, 200, 'linear', function()
                {
                });
            });
            hidemore.click( function()
            {
                showmore.css({'display':'inline-block'});
                hidemore.css({'display':'none'});

                var h = textInner.height();
                text.stop().animate({'max-height':<?= $innerHeight ?>}, 200, 'linear', function()
                {
                    textBg.show();
                });
            });
        });
    });
</script>

<?php

$menu = & JSite::getMenu();
$active = $menu->getActive();

echo '<div class="componentheading'.$pageSuff.'">';
    echo $this->escape($active->name).'&nbsp;';

    foreach ($this->years as $year)
    {
        echo '<div class="year'.$pageSuff.'">';
        if ($year == $this->currYear)
            echo '<b>'.$year.'</b>';
        else
            echo '<a href="'.JRoute::_('index.php?option=com_news&year='.$year).'">'.$year.'</a>';
        echo '</div>';
    }
echo '</div>';


echo '<div class="content-indent">';
if (empty($this->news))
{
    echo 'На сегодня новых новостей нет.';
}
else
{
    foreach ($this->news as $month => $items)
    {
        echo '<div class="content-h1  contentheading'.$pageSuff.'">';
        echo $this->monthTitle($month);
        echo '</div>';
        $i = 0;
        foreach ($items as $item)
        {
            if ($i++ == 0)
            {
                echo '<table class="table'.$pageSuff.' first">';
            }
            else
            {
                echo '<div class="separator'.$pageSuff.'"></div>';
                echo '<table class="table'.$pageSuff.'">';
            }
            ?>
            <tr>
            
                <td class="image<?= $pageSuff ?>">
                <?php
                    if ($item['mainimage'])
                        echo '<img src="'.$item['mainimage'].'" alt="'.$this->escape($item['title']).'">';
                    else
                        echo '<div class="image_blank'.$pageSuff.'"></div>';
                ?>
                </td>

                <td class="content<?= $pageSuff ?>">
                    <div class="date<?= $pageSuff ?>">
                        <?= $item['date'] ?>
                    </div>
                    <div class="title<?= $pageSuff ?>">
                        <?= $this->escape($item['title']) ?>
                    </div>
                    <div class="text<?= $pageSuff ?>" style="max-height:<?= $innerHeight ?>px">
                        <div class="text_inner<?= $pageSuff ?>">
                            <?= $item['fulltext'] ?>
                        </div>
                        <img class="text_bg<?= $pageSuff ?>" width="100%" height="50px" src="templates/catalog/images/news_grad.png">
                    </div>
                    <div class="showmore<?= $pageSuff ?>">
                        Подробнее
                    </div>
                    <div class="hidemore<?= $pageSuff ?>">
                        Свернуть
                    </div>
                </td>

            </tr>
            </table>
            <?php
        }
    }
}
echo '</div>';

echo '<div style="width:100%; text-align:center;">';
echo $this->pagination->getPagesLinks();
echo '</div>';
echo '</form>';
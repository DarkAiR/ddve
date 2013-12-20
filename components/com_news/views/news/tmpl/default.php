<?php  
defined('_JEXEC') or die('Restricted access');

$pageSuff = '_news';//$this->escape($this->params->get('pageclass_sfx'));
$innerHeight = 50;
?>

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
            {
                showmore.css({'display':'inline-block'});
            }

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
echo $this->escape($active->name);
echo '</div>';

echo '<div class="content-indent">';
if (empty($this->items))
{
    echo 'На сегодня новых новостей нет.';
}
else
{
    foreach ($this->items as $item)
    {
        ?>
        <div class="separator<?= $pageSuff ?>"></div>

        <table class="table<?= $pageSuff ?>">
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
echo '</div>';
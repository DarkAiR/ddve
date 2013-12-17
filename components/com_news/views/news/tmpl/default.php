<?php  
defined('_JEXEC') or die('Restricted access');

$pageSuff = '_news';//$this->escape($this->params->get('pageclass_sfx'));
$innerHeight = 50;
?>

<script type="text/javascript">
    jQuery(document).ready( function()
    {
        var texts = jQuery('.text<?= $pageSuff ?>');
        texts.click( function()
        {
            var self = jQuery(this);
            var isOpen = self.attr('data-open');

            if (isOpen == 0)
            {
                self.attr('data-open', 1);
                var h = self.find('.text_inner<?= $pageSuff ?>').height();
                if (h < <?= $innerHeight ?>)
                    h = <?= $innerHeight ?>;
                self.stop().animate({'height':h}, 100, 'linear', function()
                {
                    self.css({'overflow':'initial'});
                });
            }
            else
            {
                self.attr('data-open', 0);
                var h = self.find('.text_inner<?= $pageSuff ?>').height();
                self.stop().animate({'height':<?= $innerHeight ?>}, 100, 'linear', function()
                {
                    self.css({'overflow':'hidden'});
                });
            }
        });
        console.log(texts);
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
    $i = 0;
    foreach ($this->items as $item)
    {
        if ($i++ > 0)
        {
            echo '<div class="separator'.$pageSuff.'"></div>';
        }
        echo '<table class="table'.$pageSuff.'">';
        echo '<tr>';
        
            echo '<td class="image'.$pageSuff.'">';
                echo '<img src="'.$item['mainimage'].'" alt="'.$this->escape($item['title']).'">';
            echo '</td>';

            echo '<td class="content'.$pageSuff.'">';
                echo '<div class="date'.$pageSuff.'">';
                    echo $item['date'];
                echo '</div>';
                echo '<div class="title'.$pageSuff.'">';
                    echo $this->escape($item['title']);
                echo '</div>';
                echo '<div class="text'.$pageSuff.'" data-open="0" style="height:'.$innerHeight.'px">';
                    echo '<div class="text_inner'.$pageSuff.'">';
                        echo $item['fulltext'];
                    echo '</div>';
                echo '</div>';
            echo '</td>';

        echo '</tr>';
        echo '</table>';
    }
}
echo '</div>';
<?php  
defined('_JEXEC') or die('Restricted access');

$pageSuff = '_actions';//$this->escape($this->params->get('pageclass_sfx'));

$menu = & JSite::getMenu();
$active = $menu->getActive();

echo '<div class="componentheading'.$pageSuff.'">';
echo $this->escape($active->name);
echo '</div>';

echo '<div class="content-indent">';
if (empty($this->items))
{
    echo 'На данный момент у нас не проходят никакие акции.';
}
else
{
    foreach ($this->items as $item)
    {
        echo '<div class="content-h1  contentheading'.$pageSuff.'">';
        echo $this->escape($item['title']);
        if ($item['rollday'])
            echo '<img class="rollday'.$pageSuff.'" src="templates/catalog/images/1day_logo_small.png" width="50px">';
        echo '</div>';

        echo '<div class="text'.$pageSuff.'">';
        echo $item['text'];
        echo '</div>';

        echo '<div class="smalltext'.$pageSuff.'">';
        echo nl2br($item['smalltext']);
        echo '</div>';

        echo '<div class="separator'.$pageSuff.'">&nbsp;</div>';
    }
}
echo '</div>';
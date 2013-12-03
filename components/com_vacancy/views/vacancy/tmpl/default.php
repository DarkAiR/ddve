<?php  
defined('_JEXEC') or die('Restricted access');

$pageSuff = '';//$this->escape($this->params->get('pageclass_sfx'));

$menu = & JSite::getMenu();
$active = $menu->getActive();

echo '<div class="componentheading'.$pageSuff.'">';
echo $this->escape($active->name);
echo '</div>';

echo '<div class="content-indent">';
foreach ($this->items as $item)
{
    echo '<div class="componentheading'.$pageSuff.'">';
    echo $this->escape($item['title']);
    echo '</div>';

    echo '<table class="contentpaneopen'.$pageSuff.'">';

        echo '<tr>';
        echo '<td valign="top">';

            echo '<table width="100%">';
                if (!empty($item['required']))
                {
                    echo '<tr>
                            <td width="150px">Требования</td>
                            <td>'.$item['required'].'</td>
                        </tr>';
                }
                if (!empty($item['skills']))
                {
                    echo '<tr>
                            <td>Навыки</td>
                            <td>'.$item['skills'].'</td>
                        </tr>';
                }
                if (!empty($item['responsibility']))
                {
                    echo '<tr>
                            <td>Обязанности</td>
                            <td>'.$item['responsibility'].'</td>
                        </tr>';
                }
                if (!empty($item['required']))
                {
                    echo '<tr>
                            <td>Условия</td>
                            <td>'.$item['conditions'].'</td>
                        </tr>';
                }
            echo '</table>';

            if (!empty($item['address']))
            {
                echo '<div>
                        <span>Адрес</span>
                        <span>'.$item['address'].'</span>
                    </div>';
            }          
            if (!empty($item['phone']))
            {
                echo '<div>
                        <span>Контактный телефон</span>
                        <span>'.$item['phone'].'</span>
                    </div>';
            }          
            if (!empty($item['info']))
            {
                echo '<div>'.$item['info'].'</div>';
            }

        echo '</td>';
        echo '</tr>';

    echo '</table>';
    echo '<span class="article_separator">&nbsp;</span>';
}
echo '</div>';
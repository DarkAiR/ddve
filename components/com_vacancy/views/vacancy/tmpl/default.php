<?php  
defined('_JEXEC') or die('Restricted access');

$pageSuff = '_vacancy';//$this->escape($this->params->get('pageclass_sfx'));

$menu = & JSite::getMenu();
$active = $menu->getActive();

echo '<div class="componentheading'.$pageSuff.'">';
echo $this->escape($active->name);
echo '</div>';

echo '<div class="content-indent">';
if (empty($this->items))
{
    echo 'На данный момент у нас нет ни одной свободной вакансии.';
}
else
{
    foreach ($this->items as $item)
    {
        echo '<div class="content-h1  contentheading'.$pageSuff.'">';
        echo $this->escape($item['title']);
        echo '</div>';

        echo '<table class="contentpaneopen'.$pageSuff.'" border=0 cellpadding=0 cellspacing=0>';

            echo '<tr>';
            echo '<td valign="top">';

                if (!empty($item['info']))
                {
                    echo '<div class="info'.$pageSuff.'">'.$item['info'].'</div>';
                }

                echo '<table class="table'.$pageSuff.'" border=0 cellpadding=0 cellspacing=0>';
                    if (!empty($item['required']))
                    {
                        echo '<tr>
                                <td width="150px" class="content-h2 label'.$pageSuff.'">Требования</td>
                                <td class="value'.$pageSuff.'">'.$item['required'].'</td>
                            </tr>';
                    }
                    if (!empty($item['skills']))
                    {
                        echo '<tr>
                                <td class="content-h2 label'.$pageSuff.'">Навыки</td>
                                <td class="value'.$pageSuff.'">'.$item['skills'].'</td>
                            </tr>';
                    }
                    if (!empty($item['responsibility']))
                    {
                        echo '<tr>
                                <td class="content-h2 label'.$pageSuff.'">Обязанности</td>
                                <td class="value'.$pageSuff.'">'.$item['responsibility'].'</td>
                            </tr>';
                    }
                    if (!empty($item['required']))
                    {
                        echo '<tr>
                                <td class="content-h2 label'.$pageSuff.'">Условия</td>
                                <td class="value'.$pageSuff.'">'.$item['conditions'].'</td>
                            </tr>';
                    }
                echo '</table>';

                echo '<div class="inner_separator'.$pageSuff.'"></div>';
                if (!empty($item['address']))
                {
                    echo '<div>
                            <span class="content-h2 address_label'.$pageSuff.'">Адрес:</span>
                            <span class="content-h2 address_value'.$pageSuff.'">'.$item['address'].'</span>
                        </div>';
                }          
                if (!empty($item['phone']))
                {
                    echo '<div>
                            <span class="content-h2 phone_label'.$pageSuff.'">Контактный телефон:</span>
                            <span class="content-h2 phone_value'.$pageSuff.'">'.$item['phone'].'</span>
                        </div>';
                }          

            echo '</td>';
            echo '</tr>';

        echo '</table>';
        echo '<div class="separator'.$pageSuff.'">&nbsp;</div>';
    }
}
echo '</div>';
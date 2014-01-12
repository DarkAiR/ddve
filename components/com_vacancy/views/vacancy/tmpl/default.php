<?php  
defined('_JEXEC') or die('Restricted access');

$pageSuff = '_vacancy';//$this->escape($this->params->get('pageclass_sfx'));
?>

<script type="text/javascript">

(function($) {
    $(document).ready( function()
    {
        $('.vacancy-resume-btn').click( function()
        {
            var self = $(this);
            var id = self.attr('data-id');
            var title = self.attr('data-title');
            $('#myModal').modal();
            console.log(id, title);
        });
    });
})(jQuery);

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
    echo 'На данный момент у нас нет ни одной свободной вакансии.';
}
else
{
    foreach ($this->items as $item)
    {
        $title = $this->escape($item['title']);

        echo '<div class="content-h1  contentheading'.$pageSuff.'">';
        echo $title;
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

/*        echo '<button class="btn btn-primary btn-lg vacancy-resume-btn"
                data-id="'.$item['id'].'"
                _data-toggle="modal"
                data-target="#myModal"
                data-title="'.$title.'">Отправить резюме</button>';
*/
        echo '<div class="separator'.$pageSuff.'">&nbsp;</div>';
    }
}
echo '</div>';


?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
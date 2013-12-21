<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
jimport( 'joomla.application.component.model' );
 
class NewsViewNews extends JView
{
    private static $month = array(
        1 => array('Январь', 'января'),
        2 => array('Февраль', 'февраля'),
        3 => array('Март', 'марта'),
        4 => array('Апрель', 'апреля'),
        5 => array('Май', 'мая'),
        6 => array('Июнь', 'июня'),
        7 => array('Июль', 'июля'),
        8 => array('Август', 'августа'),
        9 => array('Сентябрь', 'сентября'),
        10 => array('Октябрь', 'октября'),
        11 => array('Ноябрь', 'ноября'),
        12 => array('Декабрь', 'декабря')
    );

    function display($tpl = null)
    {
        $model =& $this->getModel();
        $items = $model->getData();
        $years = $model->getYears();
        $pagination =& $this->get('Pagination');

        // Готовим дату под нужный формат
        // Разбиваем новости по месяцам
        $newsArr = array();
        foreach ($items as &$item)
        {
            $date = strtotime($item['date']);
            $month = date('n',$date);
            $year = date('Y',$date);
            $dateStr = date('j',$date).' '.self::$month[$month][1].' '.$year;
            $item['date'] = $dateStr;

            $newsArr[$month][] = $item;
        }

        $this->assignRef( 'news', $newsArr );
        $this->assignRef( 'years', $years );
        $this->assignRef( 'pagination', $pagination );
        parent::display($tpl);
    }

    public function monthTitle($month)
    {
        return self::$month[$month][0];
    }
}
<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
jimport( 'joomla.application.component.model' );
 
class NewsViewNews extends JView
{
    function display($tpl = null)
    {
        $model =& $this->getModel();
        $items = $model->getItems();

        // Готовим дату под нужный формат
        foreach ($items as &$item)
        {
            $item['date'] = $this->convertDate($item['date']);
        }

        $this->assignRef( 'items', $items );
        parent::display($tpl);
    }

    private function convertDate($date)
    {
        static $month = array(
            1 => 'января',
            2 => 'февраля',
            3 => 'марта',
            4 => 'апреля',
            5 => 'мая',
            6 => 'июня',
            7 => 'июля',
            8 => 'августа',
            9 => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря'
        );
        $date = strtotime($date);
        $str = date('j',$date).' '.$month[date('n',$date)].' '.date('Y',$date);
        return $str;
    }
}
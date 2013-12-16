<?php
// Защита от прямого обращения к скрипту
defined( '_JEXEC' ) or die( 'Restricted access' );

// Подключение файла контроллера
require_once( JPATH_COMPONENT.DS.'controller.php' );

// По необходимости подключаем дополнительный контроллер.
if ($controller = JRequest::getWord('controller')) {
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)) {
      require_once $path;
    } else {
        $controller = '';
    }
}

// Создание класса нашего компонента
$classname    = 'ActionsController'.$controller;
$controller   = new $classname();

 // Выполняем задачу
$controller->execute( JRequest::getVar( 'task' ) );

// Переадресация
$controller->redirect();

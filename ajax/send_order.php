<?php

define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(__FILE__).'/..' );
define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE.'/includes/defines.php' );
require_once ( JPATH_BASE.'/includes/framework.php' );
require_once ( JPATH_BASE.'/configuration.php' );


$cfg = new JConfig();

//$mainframe =& JFactory::getApplication('site');
//$mainframe->initialise();
//JPluginHelper::importPlugin('system');
//$mainframe->route();

// authorization
//$Itemid = JRequest::getInt( 'Itemid');
//$mainframe->authorize($Itemid);

//$option = JRequest::getCmd('option');
//$mainframe->dispatch($option);

require_once '../mail/smtpmail.php';

$res = array( );
$res['result'] = 'error';

try
{
    $name       = getParam('name');
    $phone      = getParam('phone');
    $email      = getParam('email');
    $street     = getParam('street');
    $house      = getParam('house');
    $corpus     = getParam('corpus');
    $kvartira   = getParam('kvartira');
    $podezd     = getParam('podezd');
    $amperson   = getParam('amperson');
    $comment    = getParam('comment');
    $prodList   = getParam('prodList');
    //$persons    = getParam('persons');
}
catch( Exception $e )
{
    $res['errormsg'] = $e->getMessage();
    echo json_encode( $res );
    exit();
}

$db = mysql_connect( $cfg->host, $cfg->user, $cfg->password );
if (!$db) {
    die('Ошибка соединения: ' . mysql_error());
}
mysql_set_charset( 'utf8', $db );
$query = "INSERT INTO  `".$cfg->db."`.`my_users`
(`id`, `name` , `phone` , `email` , `street` , `house` , `corpse` , `flat` , `podezd`, `prodlist` )
VALUES ('0', '{$name}', '{$phone}', '{$email}', '{$street}', '{$house}', '{$corpus}', '{$kvartira}', '{$podezd}', '{$prodList}'); ";

mysql_query( $query, $db );
mysql_close( $db );

$mail_to    = 'ddve1@bk.ru';     // вам потребуется указать здесь Ваш настоящий почтовый ящик, куда должно будет прийти письмо.
//$mail_to = 'darkair@list.ru';
$message    = ''.
            "Имя: $name\r\n".
            "Телефон: $phone\r\n".
            "Email: $email\r\n".
            "Улица: $street\r\n".
            "Дом: $house\r\n".
            "Корпус: $corpus\r\n".
            "Квартира: $kvartira\r\n".
            "Подъезд: $podezd\r\n".
            "Кол-во персон: $amperson\r\n".
            "Комментарий: $comment\r\n".
            "\r\n".
            "$prodList\r\n".
            //"Кол-во персон: ".$persons."\r\n".
            "";
$subject    = 'Заказ';

ob_start();
$sended = smtpmail( $mail_to, $subject, $message );
ob_end_clean();

if( $sended )
    $res['result'] = 'success';

echo json_encode( $res );

function getParam( $name )
{
    if( !isset($_POST[$name]) )
        throw new Exception( "param $name not found" );
    return htmlspecialchars( $_POST[$name], ENT_QUOTES );
}
?>

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

    $recaptcha = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : null;
    if (empty($recaptcha)) {
        echo json_encode(array('errormsg'=>'Not valid'));
        exit();
    }

    $curl = curl_init();
    if (!$curl) {
        throw new Exception('Curl error');
    }
    curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=6Lcr1EkUAAAAAJ8av1RwTAnRKYA8dqYErhZRFQWe&response=".$recaptcha);
    $out = curl_exec($curl);
    if (!$out) {
        throw new Exception(curl_error($curl));
    }
    $res = json_decode($out);
    echo $out;
    curl_close($curl);
    die;
    
    // $hash       = getParam('courier');
    // if (md5($phone.$salt.$name) !== $hash) {
    //     throw new Exception('Not valid parameters');
    // }
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

$mail_to    = 'ddve1@yandex.ru';
//$mail_to    = 'ddve1@bk.ru';     // вам потребуется указать здесь Ваш настоящий почтовый ящик, куда должно будет прийти письмо.
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
$errorStr = ob_get_contents();
ob_end_clean();

if( $sended )
    $res['result'] = 'success';
else
    $res['errormsg'] = $errorStr;

echo json_encode( $res );

function getParam( $name )
{
    if( !isset($_POST[$name]) )
        throw new Exception( "param not found" );
    return htmlspecialchars( $_POST[$name], ENT_QUOTES );
}
?>

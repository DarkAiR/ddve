<?php

require_once '../mail/smtpmail.php';

$res = array( );
$res['result'] = 'error';

if( isset( $_POST['phone'] ) )
{
    $phone      = htmlspecialchars( $_POST['phone'], ENT_QUOTES );

    $mail_to    = 'ddve1@bk.ru';     // вам потребуется указать здесь Ваш настоящий почтовый ящик, куда должно будет прийти письмо.
//    $mail_to = 'darkair2@gmail.com';
    $message    = "Телефон: $phone\r\n";
    $subject    = 'Заказ звонка';

    ob_start();
    $sended = smtpmail( $mail_to, $subject, $message );
    $dbg = ob_get_contents();
    ob_end_clean();

    if( $sended )
        $res['result'] = 'success';
    $res['dbg'] = $dbg;
}
echo json_encode( $res );
?>

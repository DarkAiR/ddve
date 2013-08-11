<?php
session_start();
?>
<html>
<head>
<title>Обратная связь</title>
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="content-type" content="text/html; charset=windows-1251">
<style type="text/css">
<!--
.submit  {border: 1px solid #D2D2D2; background: #F2F2F2; color: #000000;}
-->
</style>
<link href="/templates/catalog/css/mail.css" rel="stylesheet" type="text/css" />
</head>

<body style="cursor: default" topmargin=5>

<?php

$replyto = '';
$phone = '';
$msg = '';
if( !empty($_POST) )
{
    $replyto       = isset($_POST['replyto'])?   $_POST['replyto'] : '';
    $phone         = isset($_POST['phone'])?     $_POST['phone'] : '';
    $msg           = isset($_POST['msg'])?       $_POST['msg'] : '';
    $keystring     = isset($_POST['keystring'])? $_POST['keystring'] : false;
    $sessKeystring = isset($_SESSION['captcha_keystring'])? $_SESSION['captcha_keystring'] : false;

    unset($_SESSION['captcha_keystring']);

    $subject     = "Ddve.ru - Feedback";

    $phone = preg_replace( '/\D/', '', $phone );

    // Замените настройки на нужные.
    $mail_to = 'ddve@bk.ru';     // вам потребуется указать здесь Ваш настоящий почтовый ящик, куда должно будет прийти письмо.
    $errmsg  = "";

    require('smtpmail.php');

    if( empty($replyto) )
        $errmsg = "Введите ваше имя";

    elseif( empty($phone) )
        $errmsg = "Введите телефон";

    elseif( empty($msg) )
        $errmsg = "Введите текст сообщения";

    elseif( $keystring === false || $sessKeystring !== $keystring)
        $errmsg = "Неправильный код";

    else
    {
        $message   = "".
            "Имя: {$replyto}\r\n".
            "Телефон: {$phone}\r\n".
            "Сообщение: {$msg}\r\n".
            "";

        $config["smtp_charset"] = 'windows-1251';

        ob_start();
        $sended = smtpmail( $mail_to, $subject, $message );
        ob_end_clean();

        if( !$sended )
            $errmsg = "Ошибка отправки письма.<br/>Пожалуйста свяжитесь с администратором сайта: {$mail_to}";
        else
        {
            echo "<br/><div class='mail_success'>Ваше письмо отправлено</div>";
            $replyto = '';
            $phone = '';
            $msg = '';
//         exit;
        }
    }
}
?>


<?php if( !empty($errmsg) ) echo "<br/><div id='err' class='mail_error'>$errmsg</div>"; ?>
<form action="/mail/mailform.php" method="POST" ENCTYPE="multipart/form-data">
<span style='display:block; width:100%; text-align:left'>Для нас очень важно знать Ваше мнение!<br/>Ведь только так мы сможем сделать наш ресторан ещё лучше!</span>
<br/>
<div>
<table width="100%" cellpadding=0 cellspacing=2 border=0>
    <tr>
        <td valign="top">Ваше имя:</td>
        <td valign="top"><input type="text" name="replyto" value="<?=$replyto?>" size=58></td>
    </tr><tr>
        <td valign="top">Телефон:</td>
        <td valign="top"><input type="text" name="phone" value="<?=$phone?>" size=58></td>
    </tr><tr>
        <td valign="top">Текст сообщения:</td>
        <td valign="top"><textarea name="msg" cols=46 rows=10 style="width: 388px; height: 200px"><?=$msg?></textarea></td>
    </tr><tr>
        <td></td>
        <td>
            <img src="/mail/make.php?<?php echo session_name()?>=<?php echo session_id()?>">
            <input type="text" name="keystring">
            <input type="submit" value="Отправить" class="submit" style="cursor: hand">
        </td>
    </tr>
</table>
</div>
</form>

</body>
</html>

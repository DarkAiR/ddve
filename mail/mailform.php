<?php
session_start();
?>
<html>
<head>
    <title>Обратная связь</title>
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link href="/templates/catalog/css/template.css" rel="stylesheet" type="text/css" />
    <link href="/templates/catalog/css/content.css" rel="stylesheet" type="text/css" />
    <link href="/templates/catalog/css/mail.css" rel="stylesheet" type="text/css" />
</head>

<body style="cursor: default" topmargin=5>

<?php

// Типы ошибок
const ERR_TYPE_NONE = 0;
const ERR_TYPE_NAME = 1;
const ERR_TYPE_PHONE = 2;
const ERR_TYPE_TEXT = 3;
const ERR_TYPE_CODE = 4;
const ERR_TYPE_SYSTEM = 5;

/**
 * XSS-protected get post parameter
 * @param  [type] $name [description]
 * @param  string $def  [description]
 * @return [type]       [description]
 */
function getPost($name, $def='')
{
    if (!isset($_POST[$name]))
        return $def;
    $val = $_POST[$name];
    $val = strip_tags($val);
    $val = htmlentities($val, ENT_QUOTES);
    return $val;
}
$replyto = '';
$phone = '';
$msg = '';

if( !empty($_POST) )
{
    $replyto       = getPost( 'replyto' );
    $phone         = getPost( 'phone' );
    $msg           = getPost( 'msg' );
    $keystring     = getPost( 'keystring', false );
    $sessKeystring = isset($_SESSION['captcha_keystring'])? $_SESSION['captcha_keystring'] : false;

    unset($_SESSION['captcha_keystring']);

    $subject     = "Ddve.ru - Feedback";

    $phone = preg_replace( '/\D/', '', $phone );

    // Замените настройки на нужные.
    $mail_to = 'ddve@bk.ru';     // вам потребуется указать здесь Ваш настоящий почтовый ящик, куда должно будет прийти письмо.
    $errType = ERR_TYPE_NONE;
    $errMsg = '';

    require('smtpmail.php');

    if( empty($replyto) )
    {
        $errType = ERR_TYPE_NAME;
        $errMsg = "Введите ваше имя";
    }
    elseif( empty($phone) )
    {
        $errType = ERR_TYPE_PHONE;
        $errMsg = "Введите телефон";
    }
    elseif( empty($msg) )
    {
        $errType = ERR_TYPE_TEXT;    
        $errMsg = "Введите текст сообщения";
    }
    elseif( $keystring === false || $sessKeystring !== $keystring)
    {
        $errType = ERR_TYPE_CODE;
        $errMsg = "Неправильный код";
    }
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
        {
            $errType = ERR_TYPE_SYSTEM;
            $errMsg = "Ошибка отправки письма.<br/>Пожалуйста свяжитесь с администратором сайта: {$mail_to}";
        }
        else
        {
            $errType = ERR_TYPE_NONE;
            $errMsg = "Ваше письмо отправлено";
            $replyto = '';
            $phone = '';
            $msg = '';
        }
    }

    $nameErrClass = '';
    $phoneErrClass = '';
    $textErrClass = '';
    $codeErrClass = '';
    switch( $errType )
    {
        case ERR_TYPE_NAME:     $nameErrClass = 'error';    break;
        case ERR_TYPE_PHONE:    $phoneErrClass = 'error';   break;
        case ERR_TYPE_TEXT:     $textErrClass = 'error';    break;
        case ERR_TYPE_CODE:     $codeErrClass = 'error';    break;
    }
}
?>


<form action="/mail/mailform.php" method="POST" ENCTYPE="multipart/form-data">
    <div class='text-italic'>Ваше мнение очень важно для нас!</div>
    <div class='text-italic'>Ведь только так мы сможем сделать наш ресторан ещё лучше!</div>
    <div class='mail-form'>
        <div class='text-italic-bold'>Пожалуйста, заполните все поля формы</div>
        <table cellpadding=0 cellspacing=0 border=0>
            <tr>
                <td class='col1'><div class='text-italic <?= $nameErrClass ?>'>Ваше имя</div></td>
                <td class='col2'><input class='<?= $nameErrClass ?>' type="text" name="replyto" value="<?=$replyto?>"></td>
            </tr><tr>
                <td><div class='text-italic <?= $phoneErrClass ?>'>Телефон</div></td>
                <td><input class='<?= $phoneErrClass ?>' type="text" name="phone" value="<?=$phone?>"></td>
            </tr><tr>
                <td><div class='text-italic <?= $textErrClass ?>'>Сообщение</div></td>
                <td><textarea class='<?= $textErrClass ?>' name="msg" rows=10><?=$msg?></textarea></td>
            </tr>
            <tr height='30px'>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td><div class='text-italic <?= $codeErrClass ?>'>Введите код, указанный на картинке</div></td>
                <td>
                    <img src="/mail/make.php?<?php echo session_name()?>=<?php echo session_id()?>">
                    <div class='captcha-block'>
                        <input class='captcha <?= $codeErrClass ?>' type="text" name="keystring">
                        <input class="submit" type="submit" value="Отправить" style="cursor: hand">
                        <?php
                            if (!empty($errMsg))
                            {
                                echo '<span class="text-italic '.($errType == ERR_TYPE_NONE ? '' : 'error').'">'.$errMsg.'</span>';
                            }
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class='signature'>
        Спасибо за отзыв!
    </div>
</form>

</body>
</html>

<?php

define( '_JEXEC', 1 );
if (!defined('JPATH_BASE')) {
    define('JPATH_BASE', dirname(__FILE__).'/..' );
}
if (!defined('DS')) {
    define( 'DS', DIRECTORY_SEPARATOR );
}

require_once ( JPATH_BASE.'/configuration.php' );
$cfg = new JConfig();

$config['smtp_username'] = $cfg->smtpuser;
$config['smtp_password'] = $cfg->smtppass;
$config['smtp_port']     = $cfg->smtpport;
$config['smtp_host']     = $cfg->smtphost;
$config['smtp_debug']    = true;
$config['smtp_charset']  = 'utf8';
$config['smtp_from']     = $cfg->mailfrom;

define ("ERROR_DONT_SEND_MAIL",     "Failed to send mail.\nPlease contact the site administrator at:");
define ("ERROR_DONT_SEND_HELO",     "Can't send HELO!");
define ("ERROR_AUTH_LOGIN",         "Can't find an answer to an authorization request.");
define ("ERROR_LOGIN_INCORRECT",    "Login authorization has not been accepted by the server!");
define ("ERROR_PASSWORD_INCORRECT", "Password was not accepted as a true server! Authorization Error!");
define ("ERROR_MAIL_FROM",          "<p> I can not send command MAIL FROM: </ p>");
define ("ERROR_RCPT_TO",            "<p> I can not send command RCPT TO: </ p>");
define ("ERROR_DATA",               "<p> I can not send command DATA </ p>");
define ("ERROR_BODY",               "<p> not able to send the message body. A letter has been sent not! </ p>");
define ("ERROR_TROUBLE",            "Problems sending mail");

function smtpmail($mail_to, $subject, $message, $headers='')
{
    global $config;

    mail($mail_to, $subject, $message, $headers);
    return true;

// phpmailer
/*
require 'PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer;

        $mail->SMTPDebug = 3;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'migratika.noreply@gmail.com';
        $mail->Password = 'mbdyGF2U87';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

$mail->setFrom('darkair2@gmail.com', 'Mailer');
$mail->addAddress('darkair2@gmail.com');     // $mail_to

$mail->Subject = $subject;
$mail->Body    = $message;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
    return false;
} else {
    echo 'Message has been sent';
    return true;
}
die;
*/
// end phpmailer

    $SEND =   "Date: ".date("D, d M Y H:i:s") . " UT\r\n";
    $SEND .=   'Subject: =?'.$config['smtp_charset'].'?B?'.base64_encode($subject)."=?=\r\n";
    if( $headers != '' )
    {
        $SEND .= $headers."\r\n\r\n";
    }
    else
    {
        $SEND .= "Reply-To: ".$config['smtp_username']."\r\n";
        $SEND .= "MIME-Version: 1.0\r\n";
        $SEND .= "Content-Type: text/plain; charset=\"".$config['smtp_charset']."\"\r\n";
        $SEND .= "Content-Transfer-Encoding: 8bit\r\n";
        $SEND .= "From: \"".$config['smtp_from']."\" <".$config['smtp_username'].">\r\n";
        $SEND .= "To: $mail_to <$mail_to>\r\n";
        $SEND .= "X-Priority: 3\r\n\r\n";
    }
    $SEND .=  $message."\r\n";

    $socket = fsockopen($config['smtp_host'], $config['smtp_port'], $errno, $errstr, 5);
    if( !$socket )
    {
        if ($config['smtp_debug'])
            echo $errno." - ".$errstr;
        return false;
    }

    if (!server_parse($socket, "220", __LINE__))
        return false;

    fputs($socket, "HELO DDve\r\n");
    if (!server_parse($socket, "250", __LINE__))
    {
        if ($config['smtp_debug'])
            echo ERROR_DONT_SEND_HELO;
        fclose($socket);
        return false;
    }

    fputs($socket, "AUTH LOGIN\r\n");
    if (!server_parse($socket, "334", __LINE__))
    {
        if ($config['smtp_debug'])
            echo ERROR_AUTH_LOGIN;
        fclose($socket);
        return false;
    }

    fputs($socket, base64_encode($config['smtp_username']) . "\r\n");
    if (!server_parse($socket, "334", __LINE__))
    {
        if ($config['smtp_debug'])
            echo ERROR_LOGIN_INCORRECT;
        fclose($socket);
        return false;
    }

    fputs($socket, base64_encode($config['smtp_password']) . "\r\n");
    if (!server_parse($socket, "235", __LINE__))
    {
        if ($config['smtp_debug'])
            echo ERROR_PASSWORD_INCORRECT;
        fclose($socket);
        return false;
    }

    fputs($socket, "MAIL FROM: <".$config['smtp_username'].">\r\n");
    if (!server_parse($socket, "250", __LINE__))
    {
        if ($config['smtp_debug']) echo ERROR_MAIL_FROM;
        fclose($socket);
        return false;
    }

    fputs($socket, "RCPT TO: <" . $mail_to . ">\r\n");
    if (!server_parse($socket, "250", __LINE__))
    {
        if ($config['smtp_debug']) echo ERROR_RCPT_TO;
        fclose($socket);
        return false;
    }

    fputs($socket, "DATA\r\n");
    if (!server_parse($socket, "354", __LINE__))
    {
        if ($config['smtp_debug']) echo ERROR_DATA;
        fclose($socket);
        return false;
    }

    fputs($socket, $SEND."\r\n.\r\n");
    if (!server_parse($socket, "250", __LINE__))
    {
        if ($config['smtp_debug']) echo ERROR_BODY;
        fclose($socket);
        return false;
    }

    fputs($socket, "QUIT\r\n");
    fclose($socket);
    return TRUE;
}
function server_parse($socket, $response, $line = __LINE__)
{
    global $config;
    $serverResponse = '';
    while (substr($serverResponse, 3, 1) != ' ')
    {
        $serverResponse = fgets($socket, 256);
        if (!$serverResponse)
        {
            if ($config['smtp_debug'])
                echo ERROR_TROUBLE."\n$response\n$line\n$serverResponse\n";
            return false;
        }
    }
    if (!(substr($serverResponse, 0, 3) == $response))
    {
        if ($config['smtp_debug'])
            echo ERROR_TROUBLE."\n$response\n$line\n$serverResponse\n";
        return false;
    }
    return true;
}

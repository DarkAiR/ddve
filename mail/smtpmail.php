<?php

define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(__FILE__).'/..' );
define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE.'/configuration.php' );
$cfg = new JConfig();

$config['smtp_username'] = $cfg->smtpuser;
$config['smtp_password'] = $cfg->smtppass;
$config['smtp_port']     = $cfg->smtpport;
$config['smtp_host']     = $cfg->smpthost;
$config['smtp_debug']    = true;
$config['smtp_charset']  = 'utf8';
$config['smtp_from']     = $cfg->mailfrom;

define ("ERROR_DONT_SEND_MAIL",     "Failed to send mail. <br/> Please contact the site administrator at:");
define ("ERROR_DONT_SEND_HELO",     "<p> I can not send HELO! </ p>");
define ("ERROR_AUTH_LOGIN",         "<p> I can not find an answer to an authorization request. </ p>");
define ("ERROR_LOGIN_INCORRECT",    "<p> Login authorization has not been accepted by the server! </ p>");
define ("ERROR_PASSWORD_INCORRECT", "<p> password was not accepted as a true server! Authorization Error! </ p>");
define ("ERROR_MAIL_FROM",          "<p> I can not send command MAIL FROM: </ p>");
define ("ERROR_RCPT_TO",            "<p> I can not send command RCPT TO: </ p>");
define ("ERROR_DATA",               "<p> I can not send command DATA </ p>");
define ("ERROR_BODY",               "<p> not able to send the message body. A letter has been sent not! </ p>");
define ("ERROR_TROUBLE",            "Problems sending mail");

function smtpmail($mail_to, $subject, $message, $headers='')
{
    global $config;
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
    if( !$socket = fsockopen($config['smtp_host'], $config['smtp_port'], $errno, $errstr, 30) )
    {
        if ($config['smtp_debug']) echo $errno."&lt;br&gt;".$errstr;
        return false;
    }

    if (!server_parse($socket, "220", __LINE__))
        return false;

    fputs($socket, "HELO " . $config['smtp_host'] . "\r\n");
    if (!server_parse($socket, "250", __LINE__))
    {
        if ($config['smtp_debug']) echo ERROR_DONT_SEND_HELO;
        fclose($socket);
        return false;
    }

    fputs($socket, "AUTH LOGIN\r\n");
    if (!server_parse($socket, "334", __LINE__))
    {
        if ($config['smtp_debug']) echo ERROR_AUTH_LOGIN;
        fclose($socket);
        return false;
    }

    fputs($socket, base64_encode($config['smtp_username']) . "\r\n");
    if (!server_parse($socket, "334", __LINE__))
    {
        if ($config['smtp_debug']) echo ERROR_LOGIN_INCORRECT;
        fclose($socket);
        return false;
    }

    fputs($socket, base64_encode($config['smtp_password']) . "\r\n");
    if (!server_parse($socket, "235", __LINE__))
    {
        if ($config['smtp_debug']) echo ERROR_PASSWORD_INCORRECT;
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
    $server_response = '';
    while (substr($server_response, 3, 1) != ' ')
    {
        if (!($server_response = fgets($socket, 256)))
        {
            if ($config['smtp_debug']) echo "<p>".ERROR_TROUBLE."</p>$response<br>$line<br>";
            return false;
        }
    }
    if (!(substr($server_response, 0, 3) == $response))
    {
        if ($config['smtp_debug']) echo "<p>".ERROR_TROUBLE."</p>$response<br>$line<br>";
        return false;
    }
    return true;
}

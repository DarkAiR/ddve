<html>
<head>
<title>Заказ каталога</title>
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="content-type" content="text/html; charset=windows-1251">
<style type="text/css">
<!--
.submit  {border: 1px solid #D2D2D2; background: #F2F2F2; color: #000000;}
-->
</style>
<link href="http://www.bosufitness.ru/templates/rhuk_solarflare_ii/css/template_css.css" rel="stylesheet" type="text/css" />
</head>

<body style="cursor: default" topmargin=5>

<?php

if( !empty($_POST) )
{
   // Замените настройки на нужные.
   $mail_to = 'darkair2@gmail.com';     // вам потребуется указать здесь Ваш настоящий почтовый ящик, куда должно будет прийти письмо.
   $type = 'plain';                            // Можно поменять на html; plain означает: будет присылаться чистый текст.
   $charset = 'windows-1251';
   $errmsg = "";
   $bound = "----------EE184493D004036";              // Граница между данными разных типов

   require_once("texts.php");
   include('smtp-func.php');

   if( empty($_POST['replyto']) )
      $errmsg = ERROR_NO_NAME;

   elseif( empty($_POST['mail_from']) )
      $errmsg = ERROR_NO_EMAIL;

   elseif( !eregi("^[a-z0-9]+(([a-z0-9_.-]+)?)@[a-z0-9+](([a-z0-9_.-]+)?)+\.+[a-z]{2,4}$", $_POST['mail_from']) )
      $errmsg = ERROR_WRONG_EMAIL;

   elseif( empty($_POST['clubname']) )
      $errmsg = ERROR_NO_CLUBNAME;

   elseif( empty($_POST['clubaddress']) )
      $errmsg = ERROR_NO_CLUBADDRESS;

//   elseif( empty($_POST['clubinfo']) )
//      $errmsg = ERROR_NO_CLUBINFO;

   else
   {
       $bFileOk = false;
       if( isset( $_FILES['clublogo'] ) )
       {
         $clublogo = &$_FILES['clublogo'];
         if( is_array($clublogo)  &&  $clublogo['error']==0  &&  $clublogo['size']!=0  &&  $clublogo['name']!=''  &&  $clublogo['tmp_name']!='' )
         {
           switch( $clublogo['type'] )
           {
           case "image/gif":
           case "image/jpeg":
           case "image/pjpeg":
             $bFileOk = true;
             break;
           }
         }
       }

       $filedata = '';
       if( $bFileOk == true )
       {
         $fn = $_FILES['clublogo']['tmp_name'];
         if( file_exists($fn)       &&
             ($f = fopen($fn,"rb")) &&
             ($size = filesize($fn)) )
         {
           $filedata = fread( $f, $size );
           fclose($f);
         }
       }

      $message   = "--$bound\r\n".
                   "Content-Type: text/$type; charset=\"$charset\"\r\n\r\n".
                   "Название: ".$_POST['clubname']."\r\n".
                   "Адрес: ".$_POST['clubaddress']."\r\n".
                   "Контактная информация: ".$_POST['clubinfo']."\r\n".
                   "--$bound\r\n".
                   "Content-Type: image/jpeg name=".$_FILES['clublogo']['name']."\r\n".
//                   "Content-Type: ".$_FILES['clublogo']['type']." name=".$_FILES['clublogo']['name']."\r\n".
                   "Content-Disposition: attachment; filename=".$_FILES['clublogo']['name']."\r\n".
                   "Content-Transfer-Encoding: base64\r\n\r\n".
                   chunk_split(base64_encode( $filedata ))."\r\n".
                   "--$bound--";
      $subject   = $_POST['subject'];
      $mail_from = $_POST['mail_from'];
      $replyto   = $_POST['replyto'];
      $headers   = "To: \"Administrator\" <$mail_to>\r\n".
                   "From: \"$replyto\" <$mail_from>\r\n".
// Отключим reply-to, т.к. фигня приходит типа ИМЯ@mail.mfitness.ru
//                   "Reply-To: $replyto\r\n".
                   "Content-Type: multipart/mixed; boundary=\"$bound\"\r\n";
      $sended = smtpmail($mail_to, $subject, $message, $headers);
      if (!$sended)
        $errmsg = ERROR_DONT_SEND_MAIL.$mail_to;
      else
      {
         echo "<br/>".SUCCESS_SEND_MAIL;
//         exit;
      }
   }
}

$replyto = isset($_POST['replyto'])? $_POST['replyto'] : '';
$mail_from = isset($_POST['mail_from'])? $_POST['mail_from'] : '';

$clubname    = isset($_POST['clubname'])?    $_POST['clubname']    : '';
$clubaddress = isset($_POST['clubaddress'])? $_POST['clubaddress'] : '';
$clubinfo    = isset($_POST['clubinfo'])?    $_POST['clubinfo']    : '';
?>


<br />
<?php if( isset($errmsg) ) echo $errmsg; ?>
<form action="mailform.php" method="POST" ENCTYPE="multipart/form-data">
<div class="content">
<table width="100%" cellpadding=0 cellspacing=2 border=0>
        <tr>
                <td valign="top">Ваше имя:</td>
                <td valign="top"><input type="text" name="replyto" value="<?=$replyto?>" size=58></td>
        </tr><tr>
                <td valign="top">Ваш e-mail:</td>
                <td valign="top"><input type="text" name="mail_from" value="<?=$mail_from?>" size=58></td>
        </tr><tr>
                <td colspan="2"><br/><br/></td>
        </tr><tr>
                <td valign="top">Название клуба*:</td>
                <td valign="top"><input type="text" name="clubname" value="<?=$clubname?>" size=58></td>
        </tr><tr>
                <td valign="top">Логотип (максимум <?php echo ini_get( 'post_max_size' );?>):</td>
                <td valign="top"><input type="file" name="clublogo" value="" size=58></td>
        </tr><tr>
                <td valign="top">Адрес*:</td>
                <td valign="top"><input type="text" name="clubaddress" value="<?=$clubaddress?>" size=58></td>
        </tr><tr>
                <td valign="top"><!--Введите тему сообщения--></td>
                <td valign="top"><input type="hidden" name="subject" value="Регистрация клуба" size=58></td>
        </tr><tr>
                <td valign="top">Контактная информация:</td>
                <td valign="top"><textarea name="clubinfo" cols=46 rows=10 style="width: 388px; height: 200px"><?=$clubinfo?></textarea></td>
        </tr><tr>
                <td></td>
                <td><input type="submit" value="Отправить" class="submit" style="cursor: hand"></td>
        </tr>
</table>
</div>
</form>

</body>
</html>























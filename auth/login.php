<?php

session_start();

require 'authIdentity.php';
require 'user.php';
require 'httpRequest.php';

if (isset($_GET['auth_token']))
{
    $identity = new GporAuthIdentity(false, false);
    $identity->setTtoken($_GET['auth_token']);
    if ($identity->authenticate())
    {
        $user = new User();
        $user->login($identity);
        // После этого будет стоять кука авторизации
    }

    $returnUrl = isset($_GET['returnUrl']) ? $_GET['returnUrl'] : null;
    $redirectUrl = empty($returnUrl)
        ? isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : HttpRequest::getRequestUri()
        : $returnUrl;

die($redirectUrl);
    HttpRequest::redirect($redirectUrl);
}
else if (isset($_GET['error']))
{
    die($_GET['error']);
    //HttpRequest->redirect('/auth/login.php?error='.$_GET['error']);;
}
throw new Exception('Страница не найдена', 404);
?>
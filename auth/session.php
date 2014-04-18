<?php
class Session
{
    public static function getState($name, $defaultValue=null)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : $defaultValue;
    }

    public static function setState($name,$value)
    {
        $_SESSION[$name] = $value;
    }
}
?>
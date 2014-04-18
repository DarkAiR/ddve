<?php
class HttpRequest
{
    private static $_requestUri;
    private static $_hostInfo;
    private static $_securePort;
    private static $_port;

    public static function getRequestUri()
    {
        if(self::$_requestUri===null)
        {
            if(isset($_SERVER['HTTP_X_REWRITE_URL'])) // IIS
                self::$_requestUri = $_SERVER['HTTP_X_REWRITE_URL'];
                
            else if(isset($_SERVER['REQUEST_URI']))
            {
                self::$_requestUri = $_SERVER['REQUEST_URI'];
                if(!empty($_SERVER['HTTP_HOST']))
                {
                    if(strpos(self::$_requestUri,$_SERVER['HTTP_HOST'])!==false)
                        self::$_requestUri = preg_replace('/^\w+:\/\/[^\/]+/', '', self::$_requestUri);
                }
                else
                {
                    self::$_requestUri = preg_replace('/^(http|https):\/\/[^\/]+/i','',self::$_requestUri);
                }
            }
            else if(isset($_SERVER['ORIG_PATH_INFO']))  // IIS 5.0 CGI
            {
                self::$_requestUri = $_SERVER['ORIG_PATH_INFO'];
                if(!empty($_SERVER['QUERY_STRING']))
                    self::$_requestUri .= '?'.$_SERVER['QUERY_STRING'];
            }
            else
            {
                throw new Exception('CHttpRequest is unable to determine the request URI.');
            }
        }

        return self::$_requestUri;
    }


    public static function redirect($url, $terminate=true, $statusCode=302)
    {
        if(strpos($url,'/')===0)
            $url = self::getHostInfo().$url;
        header('Location: '.$url, true, $statusCode);
        if ($terminate)
            die;
    }


    public static function getHostInfo($schema='')
    {
        if (self::$_hostInfo===null)
        {
            $secure = self::getIsSecureConnection();
            $http = $secure ? 'https' : 'http';

            if (isset($_SERVER['HTTP_HOST']))
            {
                self::$_hostInfo = $http.'://'.$_SERVER['HTTP_HOST'];
            }
            else
            {
                self::$_hostInfo = $http.'://'.$_SERVER['SERVER_NAME'];
                $port = $secure ? self::getSecurePort() : self::getPort();
                if (($port!==80 && !$secure) || ($port!==443 && $secure))
                    self::$_hostInfo .= ':'.$port;
            }
        }

        if ($schema!=='')
        {
            $secure = self::getIsSecureConnection();
            if($secure && $schema==='https' || !$secure && $schema==='http')
                return self::$_hostInfo;

            $port = $schema==='https' ? self::getSecurePort() : self::getPort();
            $port = ($port!==80 && $schema==='http' || $port!==443 && $schema==='https')
                ? ':'.$port
                : '';

            $pos = strpos(self::$_hostInfo,':');
            return $schema.substr(self::$_hostInfo, $pos, strcspn(self::$_hostInfo,':',$pos+1)+1) . $port;
        }
        return self::$_hostInfo;
    }

    public static function getIsSecureConnection()
    {
        return isset($_SERVER['HTTPS']) && !strcasecmp($_SERVER['HTTPS'],'on');
    }

    public static function getSecurePort()
    {
        if (self::$_securePort===null)
            self::$_securePort = self::getIsSecureConnection() && isset($_SERVER['SERVER_PORT']) ? (int)$_SERVER['SERVER_PORT'] : 443;
        return self::$_securePort;
    }

    public static function getPort()
    {
        if (self::$_port===null)
            self::$_port = !self::getIsSecureConnection() && isset($_SERVER['SERVER_PORT']) ? (int)$_SERVER['SERVER_PORT'] : 80;
        return self::$_port;
    }
}
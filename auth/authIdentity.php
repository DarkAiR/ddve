<?php
require_once 'session.php';

class GporAuthIdentity
{
    const ERROR_AUTH_BACKEND = 200;

    const ERROR_NONE=0;
    const ERROR_USERNAME_INVALID=1;
    const ERROR_PASSWORD_INVALID=2;
    const ERROR_UNKNOWN_IDENTITY=100;

    public $errorCode = self::ERROR_UNKNOWN_IDENTITY;
    public $errorMessage = '';
    public $username;
    public $password;


    private $_id;
    private $_token;
    private $_ttoken;


    public function __construct($username,$password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getToken()
    {
        return $this->_token;
    }

    public function setTtoken($value)
    {
        $this->_ttoken = $value;
    }

    public function getTtoken()
    {
        return $this->_ttoken;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getName()
    {
        return $this->username;
    }

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        // отправляем временный токен на авторизатор
        $clientId       = 'demo';       // Yii::app()->params['auth_client'];
        $clientSecret   = 'demo';       // Yii::app()->params['auth_secret'];
        $url            = 'http://auth.dd.ru/auth/checkAuthToken/';
        $options = array(
            'query' => array (
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'auth_token'    => $this->_ttoken,
             ),
        );
        try {
            $response = $this->makeRequest($url, $options, true);
            if (isset($response->success) && $response->success) {
                Session::setState('token', $response->token);
                $this->errorCode = self::ERROR_NONE;
            } else {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            $code = $e->getCode();
            $data = array(
                'error' => array (
                    'code' => $code,
                    'message' => $error,
                )
            );
            $this->reportError($data);
            $this->errorCode = self::ERROR_AUTH_BACKEND;
            //echo CJSON::encode($data);
            //die();
        }

        return ($this->errorCode === self::ERROR_NONE) ? true : false;
    }

    public function reportError($errorData)
    {
        // todo: AUTH. obtain exception
        $errorData;
    }

    /**
     * Makes the curl request to the url.
     * @param  string  $url       url to request.
     * @param  array   $options   HTTP request options. Keys: query, data, referer.
     * @param  boolean $parseJson Whether to parse response in json format.
     * @return string  the response.
     */
    protected function makeRequest($url, $options = array(), $parseJson = true)
    {
        $ch = $this->initRequest($url, $options);

        if (isset($options['referer']))
            curl_setopt($ch, CURLOPT_REFERER, $options['referer']);

        if (isset($options['query'])) {
            $url_parts = parse_url($url);
            if (isset($url_parts['query'])) {
                $old_query = http_build_query($url_parts['query']);
                $url_parts['query'] = array_merge($url_parts['query'], $options['query']);
                $new_query = http_build_query($url_parts['query']);
                $url = str_replace($old_query, $new_query, $url);
            } else {
                $url_parts['query'] = $options['query'];
                $new_query = http_build_query($url_parts['query']);
                $url .= '?'.$new_query;
            }
        }

        if (isset($options['data'])) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $options['data']);
        }

        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);
        $headers = curl_getinfo($ch);

        if (curl_errno($ch) > 0)
            throw new Exception(curl_error($ch), curl_errno($ch));

        if ($headers['http_code'] != 200) {
            throw new Exception('Invalid response http code: '. $headers['http_code'], $headers['http_code']);
        }

        curl_close($ch);

        if ($parseJson)
            $result = $this->parseJson($result);

        return $result;
    }

    /**
     * Initializes a new session and return a cURL handle.
     * @param  string  $url       url to request.
     * @param  array   $options   HTTP request options. Keys: query, data, referer.
     * @param  boolean $parseJson Whether to parse response in json format.
     * @return cURL    handle.
     */
    protected function initRequest($url, $options = array())
    {
        $url;
        $options;

        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // error with open_basedir or safe mode
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        return $ch;
    }

    /**
     * Parse response from {@link makeRequest} in json format and check OAuth errors.
     * @param  string $response Json string.
     * @return object result.
     */
    protected function parseJson($response)
    {
        try {
            $result = json_decode($response);
            $error = $this->fetchJsonError($result);
            if (!isset($result))
                throw new Exception('Invalid response format', 500);
            
            if (isset($error))
                throw new Exception($error['message'], $error['code']);
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Returns the error info from json.
     * @param  stdClass $json the json response.
     * @return array    the error array with 2 keys: code and message. Should be null if no errors.
     */
    protected function fetchJsonError($json)
    {
        if (isset($json->error))
            return array(
                'code' => $json->error->code,
                'message' => $json->error->message,
            );
        return null;
    }
}

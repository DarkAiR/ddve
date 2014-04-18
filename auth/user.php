<?php
require_once 'session.php';

class User
{
    const IDENTITY_COOKIE = 'ddv';
    const AUTH_COOKIE_NAME = 'isauth';
    const AUTH_COOKIE_TTL = 2592000; // 3600*24*30 = 30 days

    public $guestName = 'Guest';

    public function login($identity, $duration=0)
    {
        $this->changeIdentity($identity);
        if ($duration>0)
            $this->saveToCookie($duration);
        $this->addAuthCookie();
    }


    /**
     * @return boolean whether the current application user is a guest.
     */
    public function getIsGuest()
    {
        return Session::getState('__id')===null;
    }

    public function getId()
    {
        return Session::getState('__id');
    }

    public function setId($value)
    {
        Session::setState('__id', $value);
    }

    public function getName()
    {
        $name = Session::getState('__name');
        if($name !== null)
            return $name;
        return $this->guestName;
    }

    public function setName($value)
    {
        Session::setState('__name', $value);
    }

    protected function changeIdentity($identity)
    {
        session_regenerate_id();
        $this->setId($identity->getId());
        $this->setName($identity->getName());
    }

    protected function saveToCookie($duration)
    {
        $data = array(
            $this->getId(),
            $this->getName(),
            $duration,
            $_SESSION,
        );
        setcookie(
            self::IDENTITY_COOKIE,
            md5(serialize($data)),
            time() + $duration
        );
    }

    private function getCookieDomain()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/MSIE/i',$_SERVER['HTTP_USER_AGENT'])
            ? ''
            : '.dd.ru';
    }

    private function addAuthCookie()
    {
        if (!isset($_COOKIE[self::AUTH_COOKIE_NAME]))
            setcookie( self::AUTH_COOKIE_NAME, 'true', time() + self::AUTH_COOKIE_TTL, '/', $this->getCookieDomain() );
    }
}
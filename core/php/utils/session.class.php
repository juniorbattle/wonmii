<?php

class Session
{

    public function __construct($timer)
    {
        session_cache_expire($timer);
        session_start();
    }

    public function __get($attr)
    {
        return isset($_SESSION[$attr]) ? $_SESSION[$attr] : null;
    }

    public function __set($attr, $value)
    {
        $_SESSION[$attr] = $value;
    }

    public function __unset($attr)
    {
        unset($_SESSION[$attr]);
    }

    public function Exist($attr)
    {
        return isset($_SESSION[$attr]);
    }

    public function Destroy()
    {
        foreach ($_SESSION as $key => $value)
        {
            unset($_SESSION[$key]);
        }
    }

}
?>

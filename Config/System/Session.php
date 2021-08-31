<?php
namespace System;
class Session 
{
    private $app;
    public function __construct(Application $app)
    {
       $this->app = $app;
    }
    public function start()
    {
        if(! session_id())
        {
            ini_set("session.use_only_cookies" , 1);
            session_start();
        }
    }

    public function set($key,$value)
    {
        $_SESSION[$key] = $value;
    }
    public function get($key)
    {
       return array_get_value($_SESSION,$key,"soory this $key not saved in session");
    }

    public function pull($key)
    {
        if($this->has($key))
        {
            $value =$_SESSION[$key];
            unset($_SESSION[$key]);
            return $value;
        }
        else
        {
            echo "soory this $key not saved in session";
        }
    
    }

    public function has($key)
    {
        return isset($_SESSION[$key]);
    }
    public function remove($key)
    {
        if($this->has($key))
        {
            unset($_SESSION[$key]);
        }
    }

    public function destroy()
    {
        session_destroy();
        session_unset();
    }
    public function all()
    {
        return pre($_SESSION);
    }
    
}
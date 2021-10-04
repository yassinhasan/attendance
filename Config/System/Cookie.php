<?php
namespace System;
class Cookie 
{
    private $app;
    private $domainpath;
    public function __construct(Application $app)
    {
       $this->app = $app;
    }

    public function setCookie($key,$value , $time)
    {
        // time in hr
        date_default_timezone_set('Africa/Cairo');
        $time = $time === -1 ? -1 : (time() + (3600 * $time)) ;
        setcookie($key , $value  , $time , "/" , "" , false , true);
    }
    public function get($key)
    {
       return array_get_value($_COOKIE,$key,"soory this $key not saved in session");
    }



    public function has($key)
    {
        return isset($_COOKIE[$key]);
    }
    public function remove($key)
    {
        if($this->has($key))
        {
           $this->setCookie($key,null , -1);
        }
        if(isset($_COOKIE[$key]))
        {
            unset($_COOKIE[$key]);
        }
    }

    public function removeAll()
    {
        foreach($_COOKIE as $key=>$value)
        {
            $this->remove($key);
        }
    }
    public function all()
    {
        return pre($_COOKIE);
    }

    public function getDomainPath()
    {
        $this->domainpath = $this->app->request->baseUrl();
        return $this->domainpath;
    }
    
}
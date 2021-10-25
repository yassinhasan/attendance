<?php
namespace System\Http;
use System\Application;
use System\Http\UploadFiles;
class Request 
{
    private $app;
    private $url;
    private $baseurl;
    private $file = [];
    public function __construct(Application $app)
    {
       $this->app = $app;
    }

    public function prepareUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        if(strpos($url , "?") !== false)
        {
            list($url , $request_url) = explode("?" , $url);
        }
        
        $this->url = $url;

        $this->baseurl = $this->server("REQUEST_SCHEME")."://".$this->server("HTTP_HOST")."/";


    }

    public function url()
    {
        return $this->url;
    }
    public function baseUrl()
    {
        return $this->baseurl;
    }


    public function server($key,$default=null)
    {
       return array_get_value($_SERVER,$key,$default);
    }
    public function get($key,$default=null)
    {
       return array_get_value($_GET,$key,$default);
    }
    public function post($key,$default=null)
    {
       return array_get_value($_POST,$key,$default);
    }
    public function method($key,$default=null)
    {
      return array_get_value($_POST,$key,$default);
    }

    public function file($input)
    {
        if(array_key_exists($input,$this->file))
        {
            return $this->file[$input];
        }

        $this->file[$input] = new UploadFile($input);
        return $this->file[$input];
    }
    public function files($input)
    {
        if(array_key_exists($input,$this->file))
        {
            return $this->file[$input];
        }

        $this->file[$input] = new UploadFiles($input);
        return $this->file[$input];
    }
}

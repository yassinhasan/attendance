<?php
namespace System;
use System\Application;
class Url 
{
    private $app;
    public function __construct(Application $app)
    {
       $this->app = $app;
    }


    public function link($path)
    {
        $path = ltrim($path,"/");
        $path = str_replace("\\","/",$path);
        return $this->app->request->baseUrl().$path;
    }

    public function header($path)
    {
        $url =  $this->link($path);
        header("location: $url");
        exit;
    }



}
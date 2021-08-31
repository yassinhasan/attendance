<?php 
namespace System;
use System\Application;
class Loader
{
    private $app;
    private $container = [];
    private $model = [];
    public function __construct(Application $app)
    {
     $this->app = $app;   
    }


    public function controller($contrller)
    {
        if(! $this->isInContainer($contrller))
        {
            $this->container[$contrller] = $this->prepareControl($contrller);
        }   
        return $this->container[$contrller];
    }
    public function isInContainer($contrller)
    {
        return array_key_exists($contrller , $this->container);
    }
    public function prepareControl($contrller)
    {
        $contrller = "App\\Controllers\\".ucfirst($contrller)."Controller";
        return $contrller = new $contrller($this->app);
    }

    public function action($contrller ,$action , $args)
    {
       (object) $obj = $this->controller($contrller);
        return call_user_func([$obj,$action] , $args);
     
    }
    public function model($model)
    {
        if(! $this->isInModel($model))
        {
            $this->model[$model] = $this->prepareModel($model);
        }   
        return $this->model[$model];
    }
    public function isInModel($model)
    {
        return array_key_exists($model , $this->model);
    }
    public function prepareModel($model)
    {
        $model = "App\\Models\\".ucfirst($model)."Model";
        return $model = new $model($this->app);
    }






}
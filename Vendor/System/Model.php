<?php 
namespace System;
use System\Application;
use System\Filter;
abstract class Model 
{
    use Filter;
    protected $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function __call($name, $arguments)
    {

        return call_user_func_array([$this->app->db,$name],$arguments);
    }

    public function __get($name)
    {
        return $this->app->getObject($name);
    }

    
}
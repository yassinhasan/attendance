<?php
namespace System;
use System\Application;
abstract class Controller 
{
    protected $app;
    protected $json = [];
    public function __construct(Application $app)
    {
        $this->app =$app;
    }

    public function __get($name)
    {
        return $this->app->getObject($name);
    }

    public function json()
    {
        echo json_encode($this->json);
    }
}
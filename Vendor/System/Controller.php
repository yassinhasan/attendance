<?php
namespace System;
use System\Application;
abstract class Controller 
{
    protected $app;
    public function __construct(Application $app)
    {
        $this->app =$app;
    }
}
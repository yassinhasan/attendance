<?php
namespace System;
use System\Application;
class Route 
{
    private $app;
    private $routes = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }


    //$this->addRoute("/:text:id",Home)
    // equal to route = "/"  action = "Home"  method = post


    public function addRoute($url , $action , $method = "POST")
    {
        $routes = [
            "pattern"  => $this->preparePattern($url),
            "action"   => $this->preapreAction($action),
            "url"      => $url,
            "method"   => $method
        ];
        $this->routes[] = $routes;
        return $routes;
    }

    public function preparePattern($url)
    {
        $url = str_replace("\\","/",$url);
        if(strpos($url,"/") !== 0)
        {
            $url = "/".$url;
        }
        $url = str_replace("\\" , "/" , $url);
        $pattern = "#^";
        $pattern .=str_replace([":text",":id"],["([a-zA-z0-9-]+)", "([0-9-]+)"] , $url);
        $pattern .= "$#";
        return $pattern;
    }

    public function preapreAction($action)
    {
         $action = str_replace("/" , "\\", $action);

        if(! strpos($action,"@") !== false )
        {
            $action .= "@index";
        }
        return $action;
    }

    public function routes()
    {
        return $this->routes;
    }



    public function matchUrl($pattern)
    {
        return preg_match($pattern , $this->app->request->url());
    }

    public function getArgs($pattern)
    {
        $args = [];
        preg_match_all($pattern , $this->app->request->url() , $matches);
        array_shift($matches);
        if(!empty($matches)){
            $args = array_merge($matches[0] , $matches[1]);
           
       }
       $args = array_filter($args,"filterstring");
        return $args;
  
    }
    public function isMatch()
    {
    
        foreach($this->routes as $route)
        {

            if($this->matchUrl($route['pattern']))
            {  
                
                $args = $this->getArgs($route['pattern']);
                list($controller , $action)  = explode("@",$route['action']);

                return [$controller , $action ,$args];
            }            
        }
        


    }





}

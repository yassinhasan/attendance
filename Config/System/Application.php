<?php
namespace System;

use Closure;

class Application 
 {
    private static $instance;
    private $file;
    private $container = [];
    public function __construct(File $file)
    {
        $this->addInContainer("file" , $file);
        $this->file = $file;
        static::$instance = $this;
        $this->autoload();
        $this->getHelperFile();
        $this->getVendorAutoload();
    }



    public static function getInstance($file = null)
    {
        if(is_null(static::$instance))
        {
            static::$instance = new static($file);
        }
        return static::$instance;
    }

    public function autoload()
    {
        spl_autoload_register([$this,"loadClasses"]);
    }

    public function loadClasses($class)
    {


        if(strpos($class,"App") === 0)
        {
            if(file_exists($this->file->toFile($class)))
            {
                $this->file->require($class);
            }
            else
            {
               // $this->url->header("notfound");
            }
    
        }
        elseif(strpos($class,"System") === 0)
        {
            $this->file->require("Config\\$class");
            
        }


    }


    public function __get($name)
    {
        return $this->getObject($name);
    }  
    
    public function getObject($name)
    {

        if(! $this->isShare($name))
        {
            if($this->isCoreClasses($name))
            {
            $this->addInContainer($name,$this->makeObject($name));                
            }
            else
            {
                echo "sorry this $name class is not found ";
            }

        }
        return $this->container[$name];
    }
    public function isShare($key)
    {
        return array_key_exists($key,$this->container);
    }

    public function addInContainer($key,$value)
    {
      if($value instanceof Closure)
      {
        
        $value = call_user_func($value , $this);
         
        
      }
      $this->container[$key] = $value;
    }

    
    public function coreclasses()
    {
        return [
            "session" => "System\\Session", //done
            "response" => "System\\Http\\Response", //done
            "request" => "System\\Http\\Request", //done
            "route"  => "System\\Route", // done
            "load" => "System\\Loader",  // done
            "view"   => "System\\View\\ViewFactory", //done
            "db"    =>  "System\\DataBase", // done
            "cookie" => "System\\Cookie", //done
            "html"   => "System\\Html", // done
            "url"     => "System\\Url", //done
            "validator"  => "System\\Validator", // done
            "pagination"  => "System\\Pagination"

        ];
    }

    public function isCoreClasses($key)
    {
        return array_key_exists($key,$this->coreclasses());
    }

    public function makeObject($key)
    {
        $coreclasses = $this->coreclasses();
        $obj = new $coreclasses[$key]($this);
        return $obj;
    }
    public function getHelperFile()
    {
         $this->file->require("Config\\System\\helper");
         $this->file->require("Config\\System\\Mail");
    }
    public function getVendorAutoload()
    {
        return $this->file->require("Vendor\\autoload");
    }

    public function run()
    {
        $this->session->start();
        $this->request->prepareUrl();
        $this->file->require("App/index");
        list($controller , $action , $args) = $this->route->isMatch();
        $output = (string) $this->load->action($controller,$action,$args);
       
        $this->response->setOutput($output);
        $this->response->send();
    }
    

 }
<?php
namespace System;
class File 
{

    private $dir;
    const DS = DIRECTORY_SEPARATOR;
    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    public function dir()
    {
        return $this->dir;
    }
    public function toFile($filename)
    {
       $filename = str_replace("/",self::DS,$filename);
       return $this->dir().self::DS.$filename.".php";
    }

    public function require($filename)
    {

        if(file_exists($this->toFile($filename)))
        {
          return  require $this->toFile($filename);
        }
        else
        {
            echo "soory no file found $filename"."<br>";
        }
    }

    public function toConfig($filename)
    {
       $filename = "Config".self::DS.$filename.".php";
       $filename = str_replace("/",self::DS,$filename);
       return $this->dir().self::DS.$filename;
    }
    public function toPublic($filename)
    {
        $filename = "Public".self::DS.$filename.".php";
        $filename = str_replace("/",self::DS,$filename);
        return $this->dir().self::DS.$filename;
    }
    public function toPublicWithoutExtension($filename)
    {
        $filename = "Public".self::DS.$filename;
        $filename = str_replace("/",self::DS,$filename);
        return $this->dir().self::DS.$filename;
    }

    
}
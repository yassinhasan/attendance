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
        $filename = str_replace("/",self::DS,$filename);
        if(file_exists($filename))
        {
            require $filename;
        }
        else
        {
            echo "soory no file found $filename";
        }
    }

    public function toVendor($filename)
    {
       $filename = "Vendor".self::DS.$filename.".php";
       $filename = str_replace("/",self::DS,$filename);
       return $this->dir().self::DS.$filename;
    }
    public function toPublic($filename)
    {
        $filename = "Public".self::DS.$filename.".php";
        $filename = str_replace("/",self::DS,$filename);
        return $this->dir().self::DS.$filename;
    }

    
}
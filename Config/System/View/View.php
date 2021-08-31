<?php
namespace System\View;
use System\Application;
class View 
{
    private $pathview;
    public $data = [];
    private $app;
    private $output;
    public function __construct(Application $app, $path , $data)
    {
        $this->app = $app;
        $this->data = $data;
        $this->preparePathView($path);
    }

    public function preparePathView($path)
    {
        $relativepath = "App/Views/".$path;
        $relativepath =  $this->app->file->toFile($relativepath);

        if(! file_exists($relativepath))
        {
            echo "soory this $path is not found";
        }
       return $this->pathview =  $relativepath;
    }

    public function setOutput()
    {

        if(is_null($this->output))
        {
           ob_start();
           extract($this->data); 
           if(file_exists($this->pathview))
           {
            require $this->pathview;
           }
            $this->output = ob_get_clean();
        }
        return $this->output;
    }

    public function __toString()
    {
      return  $this->setOutput();
    }
}
<?php
namespace System;
use System\Application;
class Html 
{
    private $app;
    private $title;
    private $descrpition;
    private $keywords;
    private $breadcrumb;


    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }
    public function setBreadcrumb($breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;
    }

    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }
    public function setDesc($descrpition)
    {
        $this->descrpition = $descrpition;
    }

    public function getDesc()
    {
        return $this->descrpition;
    }
    public function setKeywords($keywords)
    {
        $this->tkeywordsitle = $keywords;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

}
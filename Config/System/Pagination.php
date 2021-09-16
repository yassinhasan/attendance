<?php 
namespace System;
use System\Application;
class Pagination 
{
    private $app;
    private $limit;
    private $count;
    private $currentpage = 1;
    private $offset = 0;
    public function __construct(Application $app )
    {
           $this->app = $app; 
           $this->setCuurentPage();
           $this->setLimit();
           $this->setOffset();
           return $this;
    }   
    
    //$pagination = $this->pagination->setCount(20)->setCuurentPage()->setLimit(5)->setOffset();

    // $cuurentpage =  $pagination->cuurentpage()
    // $limit    = $pagination->limit()
    //$totalpage =  $pagination->getPages()
    //$offset    =  $pagination->getOffset()
    public function setLimit()
    {
        $limit = $this->app->request->post("limit");
        $this->limit = (null != $limit) ? $limit : 5;
        $this->limit = $limit;
        return $this;
    }
    public function getLimit()
    {

        return $this->limit;
    }

    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }
    public function getCount()
    {
        return $this->count;
    }

    public function getPages()
    {
        return ceil($this->count / $this->limit);
    }

    public function setCuurentPage()
    {
        $currentpage = $this->app->request->post("currentpage");
        $this->currentpage = (null != $currentpage) ? $currentpage : 1;
        return $this;
    }
    public function getCurrentPage()
    {
        return $this->currentpage;
    }

    public function setOffset()
    {
        // count = 90   limit = 10  so pages = 9 currentpage = 1 offset i need it =  0 
        $offset = $this->getLimit() *  ($this->getCurrentPage() - 1 );
        $this->offset = $offset;
       return $this;
    }
    public function getOffset()
    {
        return $this->offset;
    }
    
}


/*
    private $currentpage = 1;
    private $offset;
    private $items_per_pages = 3;
    private $totalpages;
    private $allitems;
    private $firstpage = 1;
    

    public function __construct($app)
    {
        $this->app = $app;
        $this->setcurrentpage();
        $this->set_offset();
        
    }


    // total items  = 90;
    // items per page = 10;
    // no of pages  = 9;
    // current page expample will be 1 
    // i need offset  =  items per page * (current page - 1)
                    //  =   10 * 0 = 0 so offset will be zero
    
    // now iam at page 2 
                   //  =    10 * (2-1) = 10 so offset will be 10 at page 2


    // no i have current page may be == 2; 
    // no i set items per pages = 2 ;
    // i need offset now  =  2 * (2-1) == 2 ;

    private function set_offset()
    {

        $this->offset  = $this->items_per_pages * ( $this->currentpage - 1);
    }

    public function get_offset()
    {

        return $this->offset;
    }
    private function setcurrentpage()
    {
        $currentpage =  $this->app->request->get("page");
        
        
        $this->currentpage = (null != $currentpage) ? $currentpage : 1;
    }

    public function get_items_per_pages()
    {
        return $this->items_per_pages;
    }
    public function getcurrentpage()
    {
        return $this->currentpage;
    }

    public function set_all_items($allitems)
    {
        $this->allitems = $allitems;

    }

    public function get_all_items()
    {
        return $this->allitems;
    }
    public function set_total_pages()
    {
       
      return  $this->totalpages = ceil($this->get_all_items() / $this->items_per_pages) ;
    }

    public function get_total_pages()
    {

        return $this->set_total_pages();
    }

    

}

*/
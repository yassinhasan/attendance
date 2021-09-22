<?php
namespace App\Controllers\Admin;

use System\Controller;
use System\View\View;

class LayoutController extends Controller
{
    
    private $sections = [
        "header" , "nav" , "footer"
    ];
    public function render(View $content , $exclude = [])
    {
        
        foreach($this->sections as $section)
        {
    
                if(!empty($exclude))
                {
                    if(in_array($section, $exclude))
                    {
                        $data[$section] = "";
                      
                    }else 
                    {
                        $data[$section] = $this->load->controller("Admin\Common\\$section")->index(); 
                    } 
                }else 

                {
                    $data[$section] = $this->load->controller("Admin\Common\\$section")->index();  
                }

  
               

                 
    
    
        }

          $data['content'] = $content;

        return $this->view->render("admin\layout",$data);
    }
}







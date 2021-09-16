<?php
namespace App\Controllers\Admin;

use System\Controller;
use System\View\View;

class LayoutController extends Controller
{
    public function render(View $content , $exceptiion = null)
    {


        $data['header'] = $this->load->controller("Admin\Common\header")->index();
        $data['nav'] = $this->load->controller("Admin\Common\\nav")->index();
        $data['content'] =  $content;
        $data['footer'] = $this->load->controller("Admin\Common\\footer")->index();
        if(in_array($exceptiion , array_keys($data)))
        {
           $data[$exceptiion] = null;
        }
        return $this->view->render("admin\layout",$data);
    }
}
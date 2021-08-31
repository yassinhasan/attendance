<?php
namespace App\Controllers\Admin;

use System\Controller;
use System\View\View;

class LayoutController extends Controller
{
    public function render(View $content)
    {
        $data['header'] = $this->load->controller("Admin\Common\header")->index();
        $data['content'] =  $content;
        $data['footer'] = $this->load->controller("Admin\Common\\footer")->index();
        return $this->view->render("admin\layout",$data);
    }
}
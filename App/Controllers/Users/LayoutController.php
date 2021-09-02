<?php
namespace App\Controllers\Users;

use System\Controller;
use System\View\View;

class LayoutController extends Controller
{
    public function render(View $content)
    {
        $data['header'] = $this->load->controller("Users\Common\header")->index();
        $data['content'] =  $content;
        $data['footer'] = $this->load->controller("Users\Common\\footer")->index();
        return $this->view->render("users\layout",$data);
    }
}
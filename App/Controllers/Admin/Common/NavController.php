<?php
namespace App\Controllers\Admin\Common;

use System\Controller;

class NavController extends Controller
{
    public function index()
    {    
     
     $user = $this->load->model("login");
     if($user->isLogin("supervisors"))
     {
          $data['user'] = $user-> user();
     }
  
      return  $this->view->render("admin\common\\nav" , $data);
    }
}
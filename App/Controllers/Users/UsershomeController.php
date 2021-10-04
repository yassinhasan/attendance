<?php
namespace App\Controllers\Users;

use System\Controller;

class UsershomeController extends Controller
{

    public function index()
    {
      $user = $this->load->model("login");
      if(! $user->isLogin("users") AND ! $user->isLogin(" supervisors") )
      {
       
         $this->url->header("/") ;
      }

      echo "<h1> this is home for users <h1>";
     
    }

}
<?php
namespace App\Controllers\Users;

use System\Controller;

class HomeController extends Controller
{

    public function index()
    {
      $this->html->setTitle("Home");
      echo  $this->layout->render($this->view->render("users/home"));
    }

}
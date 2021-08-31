<?php
namespace App\Controllers\Admin;

use System\Controller;

class HomeController extends Controller
{

    public function index()
    {
      $this->html->setTitle("admin");
      echo  $this->layout->render($this->view->render("admin\home"));
    }

}
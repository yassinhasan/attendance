<?php
namespace App\Controllers\Admin;

use System\Controller;

class HomeController extends Controller
{

    public function index()
    {

      echo  $this->app->layout->render($this->app->view->render("admin\content"));
    }

}
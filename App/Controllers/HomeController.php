<?php
namespace App\Controllers;

use System\Controller;

class HomeController extends Controller
{

    public function index()
    {

        echo  $this->app->view->render("home");
    }

}
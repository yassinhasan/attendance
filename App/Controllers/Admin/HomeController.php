<?php
namespace App\Controllers\Admin;

use System\Controller;

class HomeController extends Controller
{

    public function index()
    {
       $test =  $this->app->view->render("home");
       pre($test);
    }

}
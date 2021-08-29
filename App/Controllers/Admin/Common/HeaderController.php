<?php
namespace App\Controllers\Admin\Common;

use System\Controller;

class HeaderController extends Controller
{
    public function index()
    {

      return  $this->app->view->render("admin\common\header");
    }
}
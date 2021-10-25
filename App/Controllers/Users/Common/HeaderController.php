<?php
namespace App\Controllers\Users\Common;

use System\Controller;

class HeaderController extends Controller
{
    public function index()
    {

      $data['title'] =  $this->html->getTitle("home");
      $data['css'] =  $this->html->getCss();
      $data['js'] =  $this->html->getJs();
      $data['favicon'] = $this->html->getCdn('favicon');
      return  $this->view->render("users\common\header",$data);
    }
}
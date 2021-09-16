<?php
namespace App\Controllers\Admin\Common;

use System\Controller;

class HeaderController extends Controller
{
    public function index()
    {

      $data['title'] =  $this->html->getTitle("admin");
      $data['css'] =  $this->html->getCss();
      $data['js'] =  $this->html->getJs();
      $data['favicon'] = $this->html->getCdn('favicon');
      return  $this->view->render("admin\common\header",$data);
    }
}
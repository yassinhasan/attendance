<?php
namespace App\Controllers\Admin\Common;

use System\Controller;

class HeaderController extends Controller
{
    public function index()
    {

      $data['title'] =  $this->html->getTitle("admin");
      $data['css'] =  $this->html->getCss("css");
      $data['js'] =  $this->html->getJs("js");
      return  $this->view->render("admin\common\header",$data);
    }
}
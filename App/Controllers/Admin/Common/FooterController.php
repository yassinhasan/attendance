<?php
namespace App\Controllers\Admin\Common;

use System\Controller;

class FooterController extends Controller
{
    public function index()
    {

      
      $data['js']=  $this->html->getJs();
      return  $this->view->render("admin\\common\\footer",$data);
    }
}
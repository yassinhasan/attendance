<?php
namespace App\Controllers\Users\Common;

use System\Controller;

class FooterController extends Controller
{
    public function index()
    {

      $data['js']=  $this->html->getJs();
      return  $this->view->render("users\\common\\footer",$data);
    }
}
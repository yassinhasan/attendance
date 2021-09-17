<?php
namespace App\Controllers\Users;

use System\Controller;

class HomeController extends Controller
{

    public function index()
    {
      $this->html->setTitle("Home");  
      $image_src = toPublicDirectory('uploades/images/1.png');
      $type = pathinfo($image_src,PATHINFO_EXTENSION);
      $file = file_get_contents($image_src);
      $icon = "data:image/".$type.";base64, ".base64_encode($file);
      $this->html->setCdn("favicon","<link rel='icon' type='image/png'  href='$icon'>");    


      echo  $this->userslayout->render($this->view->render("users/home"));
    }

}
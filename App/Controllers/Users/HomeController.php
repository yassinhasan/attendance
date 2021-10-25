<?php
namespace App\Controllers\Users;

use System\Controller;

class HomeController extends Controller
{

    public function index()
    {
      $user = $this->load->model("login");
      if($user->isLogin("users") OR $user->isLogin("supervisors") )
      {
         $this->url->header("users/usershome") ;
      }
      $this->html->setTitle("Home");  
      $this->html->setCss([
        "users/css/all.min.css",
        "users/css/bootstrap.css.map",
        "users/css/bootstrap.min.css",
        "users/css/fontawesome.min.css",
        "users/css/home.css",
      ]);  
      $this->html->setJs([
        "users/js/jquery.min.js",
        "users/js/jquery.min.js",
        "users/js/bootstrap.min.js",
        "users/js/all.min.js",
        "users/js/fontawesome.min.js",
        "users/js/home.js"
      ]);
      $image_src = toPublicDirectory('uploades/images/1.png');
      $type = pathinfo($image_src,PATHINFO_EXTENSION);
      $file = file_get_contents($image_src);
      $icon = "data:image/".$type.";base64, ".base64_encode($file);
      $this->html->setCdn("favicon","<link rel='icon' type='image/png'  href='$icon'>");    
      echo  $this->userslayout->render($this->view->render("users/home"));
    }

}
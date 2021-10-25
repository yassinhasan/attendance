<?php
namespace App\Controllers\Users;

use System\Controller;

class UsershomeController extends Controller
{

    public function index()
    {
      $user = $this->load->model("login");
      if(! $user->isLogin("users") AND ! $user->isLogin(" supervisors") )
      {
       
         $this->url->header("/") ;
      }

            $this->html->setTitle("users");
            $image_src = toPublicDirectory('uploades/images/1.png');
            $type = pathinfo($image_src,PATHINFO_EXTENSION);
            $file = file_get_contents($image_src);
            $icon = "data:image/".$type.";base64, ".base64_encode($file);
            $this->html->setCdn("favicon","<link rel='icon' type='image/png'  href='$icon'>");
            
            // all css
            $this->html->setCss([
              "users/css/all.min.css",
              "users/css/bootstrap.css.map",
              "users/css/bootstrap.min.css",
              "users/css/fontawesome.min.css",
              "users/css/users.css",
            ]);
            // all js files      
            $this->html->setJs([
              "users/js/jquery.min.js",
              "users/js/bootstrap.min.js",
              "users/js/all.min.js",
              "users/js/fontawesome.min.js",
              "users/js/users.js",
      
            ]);
            $user = $this->load->model("login");
            $id = $user->user()->id;
            $allinfo = $this->load->model("users")->getById($id);
            $data['user'] = $allinfo;

            echo  $this->userslayout->render($this->view->render("users\users" , $data));
          
     
    }

}
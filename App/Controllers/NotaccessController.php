<?php
namespace App\Controllers;

use System\Controller;

class NotaccessController extends Controller
{

    public function index()
    {

      // title
      $this->html->setTitle("Nota ccess");
      // all css
      $this->html->setCss([
        "admin/css/all.min.css",
        "admin/css/bootstrap.css.map",
        "admin/css/bootstrap.min.css",
        "admin/css/fontawesome.min.css",
      ]);
      // all js files      
      $this->html->setJs([
        "admin/js/jquery.min.js",
        "admin/js/bootstrap.min.js",
        "admin/js/all.min.js",
        "admin/js/fontawesome.min.js",

      ]);
      $image_src = toPublicDirectory('uploades/images/1.png');
      $type = pathinfo($image_src,PATHINFO_EXTENSION);
      $file = file_get_contents($image_src);
      $icon = "data:image/".$type.";base64, ".base64_encode($file);
      $this->html->setCdn("favicon","<link rel='icon' type='image/png'  href='$icon'>"); 
      echo  $this->userslayout->render($this->view->render("notaccess"));
    }

}
<?php
namespace App\Controllers\Admin;

use System\Controller;

class HomeController extends Controller
{

    public function index()
    {

      // title
      $this->html->setTitle("admin");





      // favicon

      // first get image path
      $image_src = toPublicDirectory('uploades/images/1.png');
      // $type = pathinfo($path, PATHINFO_EXTENSION);
      $type = pathinfo($image_src,PATHINFO_EXTENSION);
      $file = file_get_contents($image_src);
      $icon = "data:image/".$type.";base64, ".base64_encode($file);

      // i need image path
                   // extension
                   // get file data to encode it
                   // make encode to file by
                   // data:image/   then type then ';base64, ' then base_encode(data)
      $this->html->setCdn("favicon","<link rel='icon' 
      type='image/png' 
      href='$icon'>");
      
      // all css
      $this->html->setCss([
        "admin/css/all.min.css",
        "admin/css/bootstrap.css.map",
        "admin/css/bootstrap.min.css",
        "admin/css/fontawesome.min.css",
        "admin/css/main.css",
      ]);
      // all js files      
      $this->html->setJs([
        "admin/js/jquery.min.js",
        "admin/js/bootstrap.min.js",
        "admin/js/all.min.js",
        "admin/js/fontawesome.min.js",
        "admin/js/main.js",

      ]);

     // $user = $this->load->model("login");

      // return view home.php
      echo  $this->layout->render($this->view->render("admin\home"));
    }

}
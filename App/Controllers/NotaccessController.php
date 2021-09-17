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
        "admin/css/notaccess.css",
      ]);
      // all js files      
      $this->html->setJs([
        "admin/js/jquery.min.js",
        "admin/js/bootstrap.min.js",
        "admin/js/all.min.js",
        "admin/js/fontawesome.min.js",
        "admin/js/notaccess.js",

      ]);

      echo  $this->layout->render($this->view->render("notaccess"),"nav");
    }

}
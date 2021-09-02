<?php

use System\Application;

$app = Application::getInstance();

// users

$app->route->addRoute("/","Users/Home");
   // users ==> login page
   $app->route->addRoute("users/login","Users/Login");
   $app->route->addRoute("users/login/submit","Users/Login@submit");
   // users ==> signup page
   $app->route->addRoute("users/signup","Users/Signup");
   $app->route->addRoute("users/signup/submit","Users/Signup@submit");
   // users ==> logour
   $app->route->addRoute("users/logout","Users/Logout");

   // verify http://www.attendance.com/users/verify?email=marwamedhat87@gmail.com&code=89f549b2a5341a05a7e4afeb364599158a03a47f61301c097f

      $app->route->addRoute("users/verify","Users/Verify" , "GET");   
      $app->route->addRoute("users/verify/submit","Users/Verify@submit" , "GET");   


// admin

$app->route->addRoute("admin","Admin/Home");
   // admin ==> login page
   $app->route->addRoute("admin/login","Admin/Login");
   $app->route->addRoute("admin/login/submit","Admin/Login@submit");
   // admin ==> signup page
   $app->route->addRoute("admin/signup","Admin/Signup");
   $app->route->addRoute("admin/signup/submit","Admin/Signup@submit");
   // admin ==> logour
   $app->route->addRoute("admin/logout","Admin/Logout");

   // verify http://www.attendance.com/admin/verify?email=marwamedhat87@gmail.com&code=89f549b2a5341a05a7e4afeb364599158a03a47f61301c097f

      $app->route->addRoute("admin/verify","Admin/Verify" , "GET");   
      $app->route->addRoute("admin/verify/submit","Admin/Verify@submit" , "GET");   
   






// notfound

$app->route->addRoute("notfound","NotFound");



$app->addInContainer("layout",function($app)
{
   return $app->load->controller("Admin\Layout");
});


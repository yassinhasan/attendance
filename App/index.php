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
   $app->route->addRoute("admin/login","Admin/Login" , "POST");
   $app->route->addRoute("admin/login/submit","Admin/Login@submit" ,"POST");
   // admin ==> signup page
   $app->route->addRoute("admin/signup","Admin/Signup" , "POST");
   $app->route->addRoute("admin/signup/submit","Admin/Signup@submit" , "POST");
   // admin ==> logour
   $app->route->addRoute("admin/logout","Admin/Logout" , "POST");

   // verify http://www.attendance.com/admin/verify?email=marwamedhat87@gmail.com&code=89f549b2a5341a05a7e4afeb364599158a03a47f61301c097f

      $app->route->addRoute("admin/verify","Admin/Verify" , "GET");   
      $app->route->addRoute("admin/verify/submit","Admin/Verify@submit" , "GET");  
      
   // user groups

   $app->route->addRoute("admin/usersgroups","Admin/Usersgroups");
   $app->route->addRoute("admin/usersgroups/submit","Admin/Usersgroups@submit");
   $app->route->addRoute("admin/usersgroups/edit/:id","Admin/Usersgroups@edit","POST");
   $app->route->addRoute("admin/usersgroups/save/:id","Admin/Usersgroups@save","POST");
   $app->route->addRoute("admin/usersgroups/delete/:id","Admin/Usersgroups@delete","POST");
   $app->route->addRoute("admin/usersgroups/realtime","Admin/Usersgroups@realtime" , "POST");
   $app->route->addRoute("admin/usersgroups/search","Admin/Usersgroups@search" , "POST");
   $app->route->addRoute("admin/usersgroups/download","Admin/Usersgroups@download" , "POST");

   






// notfound

$app->route->addRoute("notfound","NotFound");



$app->addInContainer("layout",function($app)
{
   return $app->load->controller("Admin\Layout");
});

$app->addInContainer("userslayout",function($app){
      return $app->load->controller("Users\Layout");  
});

$app->route->callFirst(function($app){
    $app->load->controller("Access")->index();  
});

$app->route->addRoute("access","Access");
$app->route->addRoute("notaccess","Notaccess");


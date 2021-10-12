<?php

use System\Application;

$app = Application::getInstance();

// users

$app->route->addRoute("/","Users/Home" ,  "POST");
$app->route->addRoute("/usershome","Users/Usershome" ,  "POST");
   // users ==> login page
   $app->route->addRoute("users/login","Users/Login" , "POST");
   $app->route->addRoute("users/login/submit","Users/Login@submit" , "POST");
   // users ==> signup page
   $app->route->addRoute("users/signup","Users/Signup" , "POST");
   $app->route->addRoute("users/signup/submit","Users/Signup@submit" , "POST");
   // users ==> logour
   $app->route->addRoute("users/logout","Users/Logout" , "POST");

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

   $app->route->addRoute("admin/pharmacies","Admin/Pharmacies");

   // area groups

   $app->route->addRoute("admin/areagroups","Admin/Areagroups");
   $app->route->addRoute("admin/areagroups/submit","Admin/Areagroups@submit");
   $app->route->addRoute("admin/areagroups/edit/:id","Admin/Areagroups@edit","POST");
   $app->route->addRoute("admin/areagroups/save/:id","Admin/Areagroups@save","POST");
   $app->route->addRoute("admin/areagroups/delete/:id","Admin/Areagroups@delete","POST");
   $app->route->addRoute("admin/areagroups/realtime","Admin/Areagroups@realtime" , "POST");
   $app->route->addRoute("admin/areagroups/search","Admin/Areagroups@search" , "POST");
   $app->route->addRoute("admin/areagroups/download","Admin/Areagroups@download" , "POST");

   // pharmacies

   $app->route->addRoute("admin/pharmacies","Admin/Pharmacies");
   $app->route->addRoute("admin/pharmacies/submit","Admin/Pharmacies@submit");
   $app->route->addRoute("admin/pharmacies/edit/:id","Admin/Pharmacies@edit","POST");
   $app->route->addRoute("admin/pharmacies/save/:id","Admin/Pharmacies@save","POST");
   $app->route->addRoute("admin/pharmacies/delete/:id","Admin/Pharmacies@delete","POST");
   $app->route->addRoute("admin/pharmacies/realtime","Admin/Pharmacies@realtime" , "POST");
   $app->route->addRoute("admin/pharmacies/search","Admin/Pharmacies@search" , "POST");
   $app->route->addRoute("admin/pharmacies/download","Admin/Pharmacies@download" , "POST");

   // supervisors 

   $app->route->addRoute("admin/supervisors","Admin/Supervisors");
   $app->route->addRoute("admin/supervisors/submit","Admin/Supervisors@submit");
   $app->route->addRoute("admin/supervisors/edit/:id","Admin/Supervisors@edit","POST");
   $app->route->addRoute("admin/supervisors/preview/:id","Admin/Supervisors@preview","POST");
   $app->route->addRoute("admin/supervisors/save/:id","Admin/Supervisors@save","POST");
   $app->route->addRoute("admin/supervisors/delete/:id","Admin/Supervisors@delete","POST");
   $app->route->addRoute("admin/supervisors/realtime","Admin/Supervisors@realtime" , "POST");
   $app->route->addRoute("admin/supervisors/search","Admin/Supervisors@search" , "POST");
   $app->route->addRoute("admin/supervisors/download","Admin/Supervisors@download" , "POST");


   // pharmacists 

   $app->route->addRoute("admin/pharmacists","Admin/Pharmacists");
   $app->route->addRoute("admin/pharmacists/submit","Admin/Pharmacists@submit");
   $app->route->addRoute("admin/pharmacists/edit/:id","Admin/Pharmacists@edit","POST");
   $app->route->addRoute("admin/pharmacists/preview/:id","Admin/Pharmacists@preview","POST");
   $app->route->addRoute("admin/pharmacists/save/:id","Admin/Pharmacists@save","POST");
   $app->route->addRoute("admin/pharmacists/delete/:id","Admin/Pharmacists@delete","POST");
   $app->route->addRoute("admin/pharmacists/realtime","Admin/Pharmacists@realtime" , "POST");
   $app->route->addRoute("admin/pharmacists/search","Admin/Pharmacists@search" , "POST");
   $app->route->addRoute("admin/pharmacists/download","Admin/Pharmacists@download" , "POST");


   // profile 

   $app->route->addRoute("admin/profile","Admin/Profile");
   $app->route->addRoute("admin/profile/submit","Admin/Profile@submit");
   $app->route->addRoute("admin/profile/edit/:id","Admin/Profile@edit","POST");
   $app->route->addRoute("admin/profile/preview/:id","Admin/Profile@preview","POST");
   $app->route->addRoute("admin/profile/save/:id","Admin/Profile@save","POST");
   $app->route->addRoute("admin/profile/delete/:id","Admin/Profile@delete","POST");
   $app->route->addRoute("admin/profile/realtime","Admin/Profile@realtime" , "POST");
   $app->route->addRoute("admin/profile/search","Admin/Profile@search" , "POST");
   $app->route->addRoute("admin/profile/download","Admin/Profile@download" , "POST");

   






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


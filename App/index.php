<?php

use System\Application;

$app = Application::getInstance();

// users

$app->route->addRoute("/","Users/Home");
$app->route->addRoute("submit","Users/Home@submit","POST");


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
   






// notfound

$app->route->addRoute("notfound","NotFound");



$app->addInContainer("layout",function($app)
{
   return $app->load->controller("Admin\Layout");
});


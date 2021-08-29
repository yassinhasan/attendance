<?php

use System\Application;

$app = Application::getInstance();
$app->route->addRoute("/","Home");
$app->route->addRoute("/submit","Home@submit","POST");
$app->route->addRoute("\\admin","Admin/Home");
$app->route->addRoute(":text/:id","test");
$app->route->addRoute("notfound","NotFound");


$app->addInContainer("layout",function($app)
{
   return $app->load->controller("Admin\Layout");
});


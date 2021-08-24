<?php

use App\Controllers\HomeController;
use System\Application;

$app = Application::getInstance();
$app->route->addRoute("/","Home");
$app->route->addRoute("\\admin","Admin/Home");
$app->route->addRoute(":text/:id","test");
$app->route->addRoute("notfound","NotFound");

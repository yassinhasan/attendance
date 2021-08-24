<?php

use App\Hasan;
use System\Application;
use System\File;
use System\test;

require_once "./Vendor/System/Application.php";
require_once "./Vendor/System/File.php";

$file = new File(__DIR__);
$app = Application::getInstance($file);
$app->run();







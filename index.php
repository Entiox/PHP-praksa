<?php
require "vendor/autoload.php";
require "src/Routing/routes.php";
require "config.php";

use App\Request\Request;
use App\Routing\Router;

date_default_timezone_set("Europe/Zagreb");
$request = new Request();
Router::resolveRoute($request)->send();

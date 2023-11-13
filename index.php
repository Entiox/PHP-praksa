<?php
require "vendor/autoload.php";
require "src/Routing/Routes.php";

use App\Request\Request;
use App\Routing\Router;

$request = new Request();
Router::resolveRoute($request)->send();

<?php
    require "vendor/autoload.php";
    require "src/Routing/Routes.php";

    use App\Request\Request;

    $request = new Request();
    $router->resolveRoute($request)->send();

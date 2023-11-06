<?php
    require_once "src/routing/routes.php";
    require_once "src/routing/router.php";
    require_once "src/request/request.php";

    $firstName = "Person's first name";
    $lastName = "Person's last name";

    $request = new Request("/greeting", HttpMethod::GET, array("firstName" => $firstName, "lastName" => $lastName));
    Router::resolveRoute($request)->send();
?>
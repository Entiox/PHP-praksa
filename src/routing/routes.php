<?php
    require_once "src/routing/router.php";
    require_once "src/routing/route.php";
    require_once "src/request/request.php";
    require_once "src/httpmethod.php";
    require_once "src/response/response.php";

    Router::addRoute(new Route("/random-number", HttpMethod::GET, function($params){
        return new Response(rand()); 
    }));

    Router::addRoute(new Route("/greeting", HttpMethod::GET, function($params){
        if(!array_key_exists("firstName", $params) || !array_key_exists("lastName", $params))
        {
            return Response::getMissingParamsResponse();
        }
        return new Response("Greetings ".$params["firstName"]." ".$params["lastName"]."."); 
    }));

    Router::addRoute(new Route("/save-quote", HttpMethod::POST, function($params){
        if(!array_key_exists("quote", $params))
        {
            return Response::getMissingParamsResponse();
        }
        file_put_contents("data.txt", $params["quote"], FILE_APPEND);
        return new Response("Quote saved successfully."); 
    }));
?>
<?php
    namespace App\Routing;

    use App\Controller\IndexController;
    use App\Routing\Router;
    use App\Routing\Route;

    $controller = new IndexController();
    $router = new Router();

    $router->addRoute(new Route("/random-number", "GET", $controller, function(array $params) use ($controller){
        return $controller->indexAction(array("result" => rand())); 
    }));

    $router->addRoute(new Route("/greeting", "GET", $controller, function(array $params) use ($controller){
        if(!array_key_exists("firstName", $params) || !array_key_exists("lastName", $params))
        {
            header("HTTP/1.0 400 Bad Request");
            exit;
        }
        return $controller->indexAction(array("result" => "Greetings ".$params["firstName"]." ".$params["lastName"])); 
    }));

    $router->addRoute(new Route("/save-quote", "POST", $controller, function(array $params) use ($controller){
        if(!array_key_exists("quote", $params))
        {
            header("HTTP/1.0 400 Bad Request");
            exit;
        }
        file_put_contents("data.txt", $params["quote"]."\n", FILE_APPEND);
        return $controller->indexAction(array("result" => "Quote saved successfully.")); 
    }));
    
    $router->addRoute(new ParameterizedRoute("/messages/message/{messageId}", "GET",  $controller, function(array $params) use ($controller){
        return $controller->indexAction(array("result" => "This is message number: ".$params["messageId"])); 
    }));

    $router->addRoute(new Route("/packages", "GET",  $controller, function() use ($controller){
        return $controller->indexHtmlAction(array("result" => array(array("Mobile phone", "Charger"), "Earphones"))); 
    }));

    $router->addRoute(new Route("/trees", "GET",  $controller, function() use ($controller){
        return $controller->indexJsonAction(array("result" => array(array("name" => "Spruce", "type" => "evergreen"),
         array("name" => "Oak", "type" => "deciduous"), array("name" => "Pine", "type" => "deciduous")))); 
    }));
<?php
namespace App\Routing;

use App\Response\Response;
use App\Request\Request;

class Router
{
    private static array $routes = [];

    public static function addRoute(Route $route)
    {
        array_push(self::$routes, $route);
    }

    public static function resolveRoute(Request $request): Response
    {
        $requestUrlSegments = explode("/", $request->getUrl());

        $filteredRoutes = array_filter(self::$routes, function($route) use ($requestUrlSegments)
        {
            $routeUrlSegments = explode("/", $route->getUrl());

            if(count($requestUrlSegments) !== count($routeUrlSegments))
            {
                return false;
            }

            foreach($routeUrlSegments as $index => $routeUrlSegment)
            {
                if(strlen($routeUrlSegment >= 2) && $routeUrlSegment[0] === "{" 
                    && $routeUrlSegment[strlen($routeUrlSegment) - 1] === "}")
                {
                    if(!isset($requestUrlSegments[$index][0]))
                    {
                        header("HTTP/1.0 400 Bad Request");
                        exit;
                    }
                    continue;
                }

                if($routeUrlSegment !== $requestUrlSegments[$index])
                {
                    return false;
                }
            }

            return true;
        });

        $filteredRoute = reset($filteredRoutes);
        if($filteredRoute !== false)
        {  
            $urlParams = $filteredRoute->fetchParams($request->getUrl());
            return $filteredRoute->invokeCallback($request, $urlParams);
        }
        else
        {
            header("HTTP/1.0 404 Not Found");
            exit;
        }
    }
}

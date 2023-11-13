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
        $filteredRoutes = array_filter(self::$routes, function($route) use ($request)
        {
            if($route instanceof ParameterizedRoute)
            {
                $position = strrpos($request->getUrl(), "/");
                return $route->getUrlWithoutParam() === substr($request->getUrl(), 0, $position) && $route->getHttpMethod() === $request->getHttpMethod();
            }
            else
            {
                return $route->getUrl() === $request->getUrl() && $route->getHttpMethod() === $request->getHttpMethod();
            }
        });

        $filteredRoute = reset($filteredRoutes);
        if($filteredRoute !== false)
        {
            return $filteredRoute->invokeCallback($request);
        }
        else
        {
            header("HTTP/1.0 404 Not Found");
            exit;
        }
    }
}

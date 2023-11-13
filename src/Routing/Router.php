<?php
namespace App\Routing;

use App\Response\Response;
use App\Request\Request;

class Router
{
    private array $routes = [];

    public function addRoute(Route $route)
    {
        array_push($this->routes, $route);
    }

    public function resolveRoute(Request $request): Response
    {
        $filteredRoutes = array_filter($this->routes, function($route) use ($request)
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
            if($filteredRoute instanceof ParameterizedRoute)
            {
                return $filteredRoute->invokeCallback(
                    $request->getParams() + array("messageId" => substr(strrchr($request->getUrl(), "/"), 1)));
            }
            else
            {
                return $filteredRoute->invokeCallback($request->getParams());
            }
        }
        else
        {
            header("HTTP/1.0 404 Not Found");
            exit;
        }
    }
}

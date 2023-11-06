<?php
    require_once "src/response/response.php";
    
    class Router
    {
        private static array $routes = [];

        public static function addRoute(Route $route)
        {
            array_push(self::$routes, $route);
        }

        public static function resolveRoute(Request $request)
        {
            $filteredRoutes = array_filter(self::$routes, function($route) use ($request)
            {
                return $route->getUrl() === $request->getUrl() && $route->getHttpMethod() === $request->getHttpMethod();
            });

            $filteredRoute = reset($filteredRoutes);
            if($filteredRoute !== false)
            {
                return $filteredRoute->invokeCallback($request->getParams());
            }
            else
            {
                return Response::getInvalidRouteResponse();
            }
        }
    }
?>
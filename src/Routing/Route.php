<?php
namespace App\Routing;

use App\Request\Request;
use App\Response\Response;
use InvalidArgumentException;

class Route
{
    protected const BASE_URI = "/praksa/api/v1";

    public function __construct(private string $url, private string $httpMethod, protected $callback)
    {
        $urlSegments = explode("/", $this->url);

        foreach($urlSegments as $urlSegment) {
            if(strlen($urlSegment) === 2 && $urlSegment[0] === "{" 
                && $urlSegment[strlen($urlSegment) - 1] === "}") {
                throw new InvalidArgumentException("Specify valid parameter name.");
            }
        }
    }

    public static function get(string $url, $callback)
    {
        Router::addRoute(new static($url, Request::GET, $callback));
    }

    public static function post(string $url, $callback)
    {
        Router::addRoute(new static($url, Request::POST, $callback));
    }

    public function getUrl(): string
    {
        return self::BASE_URI.$this->url;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function invokeCallback(Request $request, array $params = []): Response
    {
        return call_user_func($this->callback, $request, ...$params);
    }

    public function fetchParams($url)
    {
        $params = [];
        $requestUrlSegments = explode("/", $url);
        $routeUrlSegments = explode("/", $this->getUrl());

        foreach($routeUrlSegments as $index => $routeUrlSegment) {
            if(strlen($routeUrlSegment >= 2) && $routeUrlSegment[0] === "{" 
                && $routeUrlSegment[strlen($routeUrlSegment) - 1] === "}") {
                if(!isset($requestUrlSegments[$index][0])) {
                    header("HTTP/1.0 400 Bad Request");
                    exit;
                }
                $params[substr($routeUrlSegment, 1, strlen($routeUrlSegment) - 2)] = $requestUrlSegments[$index];
            }
        }
        return $params;
    }
}

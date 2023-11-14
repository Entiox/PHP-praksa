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

        foreach($urlSegments as $urlSegment)
        {
            if(strlen($urlSegment >= 2) && $urlSegment[0] === "{" 
                && $urlSegment[strlen($urlSegment) - 1] === "}")
            {
                if(strlen($urlSegment) === 2 || ($urlSegment[1] === "?" && strlen($urlSegment) === 3))
                {
                    throw new InvalidArgumentException("Specify valid parameter name.");
                }
            }
        }
    }

    public static function get(string $url, $callback)
    {
        Router::addRoute(new static($url, "GET", $callback));
    }

    public static function post(string $url, $callback)
    {
        Router::addRoute(new static($url, "POST", $callback));
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
}

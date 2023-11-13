<?php
namespace App\Routing;

use App\Request\Request;
use App\Response\Response;

class Route
{
    protected const BASE_URI = "/praksa/api/v1";

    public function __construct(private string $url, private string $httpMethod, protected $callback)
    {}

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

    public function invokeCallback(Request $request): Response
    {
        return call_user_func($this->callback, $request);
    }
}

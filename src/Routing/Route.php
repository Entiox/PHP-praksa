<?php
namespace App\Routing;

use App\Controller\IndexController;
use App\Response\Response;

class Route
{
    protected const BASE_URI = "/praksa/api/v1";

    public function __construct(private string $url, private string $httpMethod, private IndexController $controller, protected $callback)
    {}

    public function getUrl(): string
    {
        return self::BASE_URI.$this->url;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function invokeCallback($params = []): Response
    {
        return call_user_func($this->callback, $params);
    }
}

<?php
namespace App\Routing;

use App\Controller\IndexController;
use InvalidArgumentException;

class ParameterizedRoute extends Route
{
    public function __construct(private string $url, private string $httpMethod, private IndexController $controller, protected $callback)
    {
        parent::__construct($url, $httpMethod, $controller, $callback);
        if(!isset($url[strrpos($url, "/") + 1]) || !isset($url[strlen($url) - 1]) 
            || $url[strrpos($url, "/") + 1] != "{" || $url[strlen($url) - 1] != "}")
        {
            throw new InvalidArgumentException("Route url is not properly defined.");
        }
    }

    public function getUrlWithoutParam(): string
    {
        return strstr($this->getUrl(), "/{", true);
    }

    public function getParamName()
    {
        return substr(strrchr($this->getUrl(), "{"), 1, -1);
    }

    public static function getParamValue(string $url)
    {
        return substr(strrchr($url, "{"), 1, -1);
    }
}

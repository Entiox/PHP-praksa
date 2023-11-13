<?php
namespace App\Request;

use App\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    public function getUrl(): string
    {
        $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        return $url;
    }

    public function getHttpMethod(): string
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    public function getParams(): array
    {
        if($_SERVER["REQUEST_METHOD"] === "POST")
        {
            return $_POST;
        }
        else
        {
            return $_GET;
        }
    }
}

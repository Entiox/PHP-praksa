<?php
namespace App\Request;

use App\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    public const GET = "GET";
    public const POST = "POST";

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
        $params = $_SERVER["REQUEST_METHOD"] === self::POST ? $_POST : $_GET;
        return $params;
    }
}

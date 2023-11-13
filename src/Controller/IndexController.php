<?php
namespace App\Controller;

use App\Request\Request;
use App\Response\JsonResponse;
use App\Response\Response;
use App\Response\HtmlResponse;

class IndexController
{
    public static function indexAction(Request $request): Response
    {
        return new Response(array("result" => array("request url" => $request->getUrl(), "parameters" => $request->getParams())));
    }

    public static function indexJsonAction($request): JsonResponse
    {
        return new JsonResponse(array("result" => array("request url" => $request->getUrl(), "parameters" => $request->getParams())));
    }

    public static function indexHtmlAction($request): HtmlResponse
    {
        return new HtmlResponse(array("result" => array("request url" => $request->getUrl(), "parameters" => $request->getParams())));
    }
}
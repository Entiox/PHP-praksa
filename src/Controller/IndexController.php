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
        return new Response(["result" => ["request url" => $request->getUrl(), "parameters" => $request->getParams()]]);
    }

    public static function indexJsonAction(Request $request): JsonResponse
    {
        return new JsonResponse(["result" => ["request url" => $request->getUrl(), "parameters" => $request->getParams()]]);
    }

    public static function indexHtmlAction(Request $request): HtmlResponse
    {
        return new HtmlResponse(["result" => ["request url" => $request->getUrl(), "parameters" => $request->getParams()]]);
    }

    public static function indexActionWithId(Request $request, $id): Response
    {
        return new Response(["result" => ["request url" => $request->getUrl(), "parameters" => $request->getParams(), "url parameters" =>  ["id" => $id]]]);
    }

    public static function indexJsonActionWithId(Request $request, $id): JsonResponse
    {
        return new JsonResponse(["result" => ["request url" => $request->getUrl(), "parameters" => $request->getParams(), "url parameters" =>  ["id" => $id]]]);
    }

    public static function indexHtmlActionWithId(Request $request, $id): HtmlResponse
    {
        return new HtmlResponse(["result" => ["request url" => $request->getUrl(), "parameters" => $request->getParams(), "url parameters" =>  ["id" => $id]]]);
    }

    public static function indexActionWithIds(Request $request, $firstId, $secondId): Response
    {
        return new Response(["result" => ["request url" => $request->getUrl(), "parameters" => $request->getParams(),
            "url parameters" => ["firstId" => $firstId, "secondId" => $secondId]]]);
    }

    public static function indexJsonActionWithIds(Request $request, $firstId, $secondId): JsonResponse
    {
        return new JsonResponse(["result" => ["request url" => $request->getUrl(), "parameters" => $request->getParams(),
            "url parameters" => ["firstId" => $firstId, "secondId" => $secondId]]]);
    }

    public static function indexHtmlActionWithIds(Request $request, $firstId, $secondId): HtmlResponse
    {
        return new HtmlResponse(["result" => ["request url" => $request->getUrl(), "parameters" => $request->getParams(),
            "url parameters" => ["firstId" => $firstId, "secondId" => $secondId]]]);
    }
}

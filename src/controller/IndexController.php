<?php
    namespace App\Controller;

    use App\Response\JsonResponse;
    use App\Response\Response;
    use App\Response\HtmlResponse;

    class IndexController
    {
        public function indexAction($content): Response
        {
            return new Response($content);
        }

        public function indexJsonAction($content): JsonResponse
        {
            return new JsonResponse($content);
        }

        public function indexHtmlAction($content): HtmlResponse
        {
            return new HtmlResponse($content);
        }
    }
<?php
    namespace App\Controller;

    use App\Response\JsonResponse;
    use App\Response\Response;
    use App\Response\HtmlResponse;
    use App\Connection\Connection;

    class IndexController
    {
        private Connection $connnection;

        public function __construct() {
            $this->connnection = Connection::getInstance();
        }

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
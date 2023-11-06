<?php
    require_once "responseinterface.php";

    class Response implements ResponseInterface
    {
        private $content;
        
        public function __construct($content = null)
        {
            $this->content = $content;
        }
        
        public function send()
        {
            echo $this->content;
        }

        public static function getMissingParamsResponse(): Response
        {
            return new Response("Missing parameter(s).");
        }

        public static function getInvalidRouteResponse(): Response
        {
            return new Response("Route not found.");
        }
    }
?>
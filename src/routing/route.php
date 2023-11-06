<?php
    require_once "src/httpmethod.php";
    require_once "src/response/response.php";

    class Route
    {
        private string $url;
        private HttpMethod $httpMethod;
        private $callback;

        public function __construct(string $url, HttpMethod $httpMethod, $callback)
        {
            $this->url = $url;
            $this->httpMethod = $httpMethod;

            if(is_callable($callback))
            {
                $this->callback = $callback;
            }
            else 
            {
                $this->callback = function() {};
            }
        }

        public function getUrl(): string
        {
            return $this->url;
        }

        public function getHttpMethod(): HttpMethod
        {
            return $this->httpMethod;
        }

        public function invokeCallback($params = []): Response
        {
            return call_user_func($this->callback, $params);
        }
    }
?>
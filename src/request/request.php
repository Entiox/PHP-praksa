<?php
    require_once "requestinterface.php";
    require_once "src/httpmethod.php";

    class Request implements RequestInterface
    {
        private string $url;
        private HttpMethod $httpMethod;
        private $params;

        public function __construct(string $url, HttpMethod $httpMethod, $params = [])
        {
            $this->url = $url;
            $this->httpMethod = $httpMethod;
            $this->params = $params;
        }

        public function getUrl(): string
        {
            return $this->url;
        }

        public function getHttpMethod(): HttpMethod
        {
            return $this->httpMethod;
        }

        public function getParams()
        {
            return $this->params;
        }
    }
?>
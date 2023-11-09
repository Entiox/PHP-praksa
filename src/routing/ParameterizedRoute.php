<?php
    namespace App\Routing;

    use App\Response\Response;

    class ParameterizedRoute extends Route
    {
        public function getUrlWithoutParam(): string
        {
            return strstr($this->getUrl(), "/{", true);
        }

        public function getUniqueParamName()
        {
            return substr(strrchr($this->getUrl(), "{"), 1, -1);
        }
    }

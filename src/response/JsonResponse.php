<?php
    namespace App\Response;

    class JsonResponse extends Response
    {
        public function send()
        {
            echo json_encode($this->content);
        }
    }

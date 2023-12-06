<?php
namespace App\Response;

use App\Interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    public function __construct(protected $content = [])
    {  
    }
    
    public function send()
    {
        $this->printArray($this->content);
    }

    public final function printArray($array, $space = 0)
    {
        foreach($array as $key => $value) {
            for ($i=0; $i < $space; $i++) { 
                echo "-";
            }

            if(!is_array($value)) {
                echo $key.": ".$value."<br>";
            } else {
                echo $key.":</br>";
                $this->printArray($value, $space + 1);
            }
        }
    }
}

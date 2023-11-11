<?php
namespace App\Response;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class HtmlResponse extends Response
{
    private $loader;
    private $twig;

    public function __construct(protected $content = [])
    {
        parent::__construct($content);
        $this->loader = new FilesystemLoader("templates/");
        $this->twig = new Environment($this->loader, [
            "cache' => 'storage/cache",
        ]);
    }

    public function send()
    {
        echo $this->twig->render("htmlresponse.twig", array("content" => $this->content));
    }
}

<?php

namespace App\Core;

use App\Core\Auth;
use App\Core\UrlManager;
use App\Libs\TwigTemplate;

class Renderer
{
    private $templateEngine;
    private $menuReader;
    private $url;
    private $auth;
    private $key;

    public function __construct(
        TwigTemplate $templateEngine,
        MenuReader $menuReader,
        UrlManager $url,
        Auth $auth,
        array $key
    ) {
        $this->templateEngine = $templateEngine;
        $this->menuReader = $menuReader;
        $this->url = $url;
        $this->auth = $auth;
        $this->key = $key;
    }

    public function render(string $template, array $data=[]): void
    {
        $data = array_merge($data, [
            'menuReader' => $this->menuReader,
            'url'  => $this->url,
            'key'  => $this->key,
            'auth' => $this->auth
        ]);

        echo $this->templateEngine->template($template, $data);
    }

    public function getTemplate(string $template, array $data=[]): string
    {
        $data = array_merge($data, [
            'url'  => $this->url,
            'auth' => $this->auth
        ]);

        return $this->templateEngine->template($template, $data);
    }
}

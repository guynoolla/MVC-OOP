<?php

namespace App\Handlers;

use App\Core\Renderer;
use App\Core\SessionManager;
use App\Models\UserModel;

class Handler
{
    protected $renderer;
    protected $session;
    protected $user;

    public function __construct(
        Renderer $renderer,
        SessionManager $session,
        UserModel $user
    ) {
        $this->renderer = $renderer;
        $this->session = $session;
        $this->user = $user;
    }

    protected function redirect($urlPath)
    {
        header("Location: " . BASE_URL . ltrim($urlPath, '/'));
    }
}

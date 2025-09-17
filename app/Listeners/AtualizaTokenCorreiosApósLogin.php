<?php

namespace App\Listeners;

use App\Services\CorreiosTokenService;
use Illuminate\Auth\Events\Login;

class AtualizaTokenCorreiosApósLogin
{
    protected CorreiosTokenService $service;

    public function __construct(CorreiosTokenService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(Login $event)
    {
        // Aqui roda a lógica para atualizar o token automaticamente
        $this->service->obterToken();
    }
}

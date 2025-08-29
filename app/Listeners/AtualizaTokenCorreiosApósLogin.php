<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Services\CorreiosTokenService;

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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // Aqui roda a lógica para atualizar o token automaticamente
        $this->service->obterToken();
    }
}
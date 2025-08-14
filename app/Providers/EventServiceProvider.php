<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * O mapeamento dos eventos para os listeners da aplicação.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Evento de login do Laravel
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\AtualizaTokenCorreiosApósLogin::class,
        ],
    ];

    /**
     * Registra quaisquer eventos para sua aplicação.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
  protected $listen = [
    // Evento de login do Laravel
    \Illuminate\Auth\Events\Login::class => [
      \App\Listeners\AtualizaTokenCorreiosApósLogin::class,
    ],
  ];

  public function boot()
  {
    //
  }
}

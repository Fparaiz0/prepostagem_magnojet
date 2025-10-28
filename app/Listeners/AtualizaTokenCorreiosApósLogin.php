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

  public function handle(Login $event)
  {
    $this->service->obterToken();
  }
}

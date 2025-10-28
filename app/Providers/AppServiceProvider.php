<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  public function register(): void
  {
    //
  }

  public function boot(): void
  {
    Paginator::useBootstrap();

    Schema::defaultStringLength(191);

    Gate::before(function ($user, $ability) {
      return $user->hasRole('Super Admin') ? true : null;
    });
  }
}

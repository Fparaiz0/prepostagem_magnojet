<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('correios:check-prepostagens')
  ->everyFifteenMinutes()
  ->timezone('America/Sao_Paulo')
  ->withoutOverlapping()
  ->runInBackground();

Artisan::command('inspire', function () {
  $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

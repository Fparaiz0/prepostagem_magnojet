<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('correios:check-prepostagens')
  ->weekdays()
  ->everyTenMinutes()
  ->timezone('America/Sao_Paulo')
  ->between('7:50', '18:10')
  ->withoutOverlapping()
  ->timeout(300);

Artisan::command('inspire', function () {
  $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

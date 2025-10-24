<?php

use App\Http\Controllers\Api\PackagingApiController;
use App\Http\Controllers\Api\RecipientApiController;
use App\Http\Controllers\Api\SenderApiController;
use App\Services\CorreiosTokenService;
use Illuminate\Support\Facades\Route;

// Rota para buscar remetente, destinatário e embalagem
Route::get('/remetentes/buscar', [SenderApiController::class, 'buscar']);
Route::get('/destinatarios/buscar', [RecipientApiController::class, 'buscar']);
Route::get('/embalagens/buscar', [PackagingApiController::class, 'buscar']);

// Rota de Geração de Token
Route::post('/token', function (CorreiosTokenService $service) {
  $token = $service->obterToken();

  if ($token) {
    return response()->json(['token' => $token]);
  }

  return response()->json(['erro' => 'Falha ao obter token'], 500);
});

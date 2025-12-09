<?php

namespace App\Services;

use App\Models\CorreiosToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;

class CorreiosTokenService
{
  protected string $usuario;
  protected string $senha;
  protected string $contrato;
  protected string $cartao;
  protected string $dr;

  private const TOKEN_VALIDITY_HOURS = 24;

  public function __construct()
  {
    $this->usuario = config('services.correios.usuario');
    $this->senha = config('services.correios.senha');
    $this->contrato = config('services.correios.contrato');
    $this->cartao = config('services.correios.cartao');
    $this->dr = config('services.correios.dr');
  }

  public function obterToken(): ?string
  {
    $tokenBanco = CorreiosToken::where('valid_until', '>', now())
      ->orderByDesc('created_at')
      ->first();

    if ($tokenBanco) {
      log::info('Token não criado, pois há um token válido no banco.');
      return $tokenBanco->token;
    }

    $response = $this->requestNewToken();

    if ($response->successful()) {
      $novoToken = $response->json('token');

      if ($novoToken) {
        CorreiosToken::create([
          'token' => $novoToken,
          'valid_until' => now()->addHours(self::TOKEN_VALIDITY_HOURS),
        ]);

        Log::info('Um novo token foi gerado e salvo com sucesso!');
        return $novoToken;
      }
    }

    Log::error("A requisição do token falhou:", [
      "status" => $response->status(),
      "response" => $response->json(),
    ]);

    return null;
  }

  private function requestNewToken(): Response
  {
    return Http::withBasicAuth($this->usuario, $this->senha)
      ->post('https://api.correios.com.br/token/v1/autentica/cartaopostagem', [
        'numero' => $this->cartao,
        'contrato' => $this->contrato,
        'dr' => $this->dr,
      ]);
  }
}
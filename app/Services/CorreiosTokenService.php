<?php

namespace App\Services;

use App\Models\CorreiosToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CorreiosTokenService
{
  protected string $usuario;

  protected string $senha;

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

    $response = Http::withBasicAuth($this->usuario, $this->senha)
      ->post('https://api.correios.com.br/token/v1/autentica/cartaopostagem', [
        'numero' => $this->cartao,
        'contrato' => $this->contrato,
        'dr' => $this->dr,
      ]);

    if ($response->successful()) {
      $validaToken = $response->json()['token'] ?? null;

      if ($validaToken) {
        if (!$tokenBanco || $tokenBanco->token !== $validaToken) {

          $novoToken = $validaToken;

          CorreiosToken::create([
            'token' => $novoToken,
            'valid_until' => now()->addDay(),
          ]);

          log::info('Um novo token foi gerado com sucesso!');
        }

        $antigoToken = $validaToken;

        log::info('Token não criado, pois há um token válido no banco.');

        return $antigoToken;
      }
    }

    Log::info("A requisição do token falhou:", ["response" => $response->json()]);

    return $tokenBanco->token ?? null;
  }
}

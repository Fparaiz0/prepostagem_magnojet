<?php

namespace App\Services;

use App\Models\CorreiosToken;
use Illuminate\Support\Facades\Http;

class CorreiosTokenService
{
    protected string $usuario;
    protected string $senha;

    public function __construct()
    {
        $this->usuario = env('CORREIOS_USUARIO');
        $this->senha = env('CORREIOS_SENHA');
    }

    /**
     * Obtém o token válido dos Correios.
     * Se não houver token válido, gera um novo e salva no banco.
     *
     * @return string|null Token válido ou null se falhar.
     */
    public function obterToken(): ?string
{
    // Recupera o token mais recente válido do banco
    $tokenBanco = CorreiosToken::where('valid_until', '>', now())
        ->orderByDesc('created_at')
        ->first();

    // Tenta obter novo token da API
    $response = Http::withoutVerifying()
        ->withBasicAuth($this->usuario, $this->senha)
        ->post('https://api.correios.com.br/token/v1/autentica/cartaopostagem', [
            'numero'   => '0067038727',
            'contrato' => '9912326924',
            'dr'       => 36,
        ]);

    if ($response->successful()) {
        $novoToken = $response->json()['token'] ?? null;

        if ($novoToken) {
            // Se for diferente do token salvo, cria novo registro
            if (!$tokenBanco || $tokenBanco->token !== $novoToken) {
                CorreiosToken::create([
                    'token' => $novoToken,
                    'valid_until' => now()->addDay(),
                ]);
            }

            return $novoToken;
        }
    }

    // Se falhou a requisição, usa o token salvo se ainda for válido
    return $tokenBanco->token ?? null;
}
}


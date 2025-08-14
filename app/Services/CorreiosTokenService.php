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
        // Tenta recuperar token válido no banco
        $token = CorreiosToken::where('valid_until', '>', now())->latest()->first();

        if ($token) {
            return $token->token;
        }

        // Não tem token válido, faz a requisição para gerar novo token
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
                CorreiosToken::create([
                    'token' => $novoToken,
                    'valid_until' => now()->addDay(), // Token válido por 1 dia
                ]);

                return $novoToken;
            }
        }

        // Falhou ao obter token
        return null;
    }
}


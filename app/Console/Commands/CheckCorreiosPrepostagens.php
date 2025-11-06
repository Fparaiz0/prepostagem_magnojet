<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\CorreiosToken;
use App\Models\Prepostagem;
use Exception;
use Carbon\Carbon;

class CheckCorreiosPrepostagens extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'correios:check-prepostagens';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Verifica na API dos Correios se as pré-postagens pendentes foram postadas.';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $token = CorreiosToken::latest()->first();
    $limiteExpiracao = Carbon::now()->subDay();

    if (!$token) {
      Log::error('Erro Fatal: Token dos Correios não encontrado no banco de dados.');
      throw new Exception('Token da API dos Correios é obrigatório para verificar pré-postagens.');
    }

    if ($token->created_at->lt($limiteExpiracao)) {
      Log::error('Erro Fatal: Token dos Correios expirou. Deve ser renovado.');
      throw new Exception('O token da API dos Correios excedeu o limite de 24 horas e deve ser atualizado.');
    }

    $prepostagensParaVerificar = Prepostagem::where('situation', 1)->get();

    foreach ($prepostagensParaVerificar as $prepostagem) {
      try {
        $response = Http::withToken($token->token)
          ->get('https://api.correios.com.br/prepostagem/v1/prepostagens/postada', [
            'codigoObjeto' => $prepostagem->object_code,
          ]);

        if ($response->successful()) {

          $data = $response->json();

          if (isset($data['codigoObjeto']) && $prepostagem->object_code === $data['codigoObjeto']) {
            $prepostagem->update(['situation' => 3]);

            Log::info('Pré-postagem marcada como postada com sucesso.', [
              'status' => $response->status(),
              'Código' => $prepostagem->object_code,
              'prepostagem_id' => $prepostagem->id,
              'dataPostagem' => $data['dataPostagem'] ?? 'N/A',
            ]);
          }
        } else {
          Log::warning('Erro ao consultar pré-postagem na API Correios.', [
            'status' => $response->status(),
            'object_code' => $prepostagem->object_code,
            'body' => $response->body(),
          ]);
        }
      } catch (Exception $e) {
        Log::error('Erro interno ao verificar pré-postagem.', [
          'error' => $e->getMessage(),
          'object_code' => $prepostagem->object_code,
        ]);
      }
    }

    Log::info('Verificação de pré-postagens concluída.');
  }
}
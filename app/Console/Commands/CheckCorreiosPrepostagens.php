<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\CorreiosToken;
use App\Models\Prepostagem;
use Exception;
use App\Services\CorreiosTokenService;

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

  protected $TokenService;

  public function __construct(CorreiosTokenService $TokenService)
  {
    parent::__construct();

    $this->TokenService = $TokenService;
  }

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $token = CorreiosToken::where('valid_until', '>', now())
      ->orderByDesc('created_at')
      ->first();

    if (!$token) {
      Log::warning('Token não encontrado no banco de dados ou expirado. Gerando um novo.');

      return $this->TokenService->obterToken();
    }

    $prepostagensParaVerificar = Prepostagem::where('situation', 1)->get();

    foreach ($prepostagensParaVerificar as $prepostagem) {
      try {
        $response = Http::withToken($token->token)
          ->get('https://api.correios.com.br/prepostagem/v1/prepostagens/postada', [
            'codigoObjeto' => $prepostagem->object_code,
          ]);

        $data = $response->json();

        if ($response->successful()) {

          if (isset($data['codigoObjeto']) && $prepostagem->object_code === $data['codigoObjeto']) {
            $prepostagem->update(['situation' => 3]);

            Log::info('Pré-postagem marcada como postada com sucesso.', [
              'status' => $response->status(),
              'codigo' => $prepostagem->object_code,
              'dataPostagem' => $data['dataPostagem'] ?? 'N/A',
            ]);
          }
        } else {
          Log::warning('Erro ao consultar pré-postagem na API Correios.', [
            'status' => $response->status(),
            'codigo' => $prepostagem->object_code,
            'mensagem' => $data['msgs'],
          ]);
        }
      } catch (Exception $e) {
        Log::error('Erro interno ao verificar pré-postagem.', [
          'error' => $e->getMessage(),
        ]);
      }
    }
    Log::info('Verificação de pré-postagens concluída.');
  }
}
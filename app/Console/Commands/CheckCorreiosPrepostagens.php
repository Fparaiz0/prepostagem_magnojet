<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\CorreiosToken;
use App\Models\Prepostagem;

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
    $this->info('Iniciando verificação de pré-postagens dos Correios...');

    $token = CorreiosToken::latest()->first();

    if (!$token) {
      Log::warning('Token dos Correios não encontrado ao tentar verificar pré-postagens.');
      $this->error('Token dos Correios não encontrado.');
      return Command::FAILURE;
    }

    $prepostagensParaVerificar = Prepostagem::where('situation', 1)->get();

    if ($prepostagensParaVerificar->isEmpty()) {
      $this->info('Nenhuma pré-postagem pendente para verificar.');
      return Command::SUCCESS;
    }

    $this->info("Encontradas {$prepostagensParaVerificar->count()} pré-postagens para verificar.");

    foreach ($prepostagensParaVerificar as $prepostagem) {
      try {
        $response = Http::withToken($token->token)
          ->get('https://api.correios.com.br/prepostagem/v1/prepostagens/postada', [
            'codigoObjeto' => $prepostagem->object_code,
          ]);

        if ($response->successful()) {
          $data = $response->json();

          if (isset($data['dataPostagem'])) {
            $prepostagem->update(['situation' => 3]);

            Log::info('Pré-postagem marcada como postada.', [
              'object_code' => $prepostagem->object_code,
              'prepostagem_id' => $prepostagem->id,
              'dataPostagem' => $data['dataPostagem'],
            ]);
            $this->line(" [OK] Pré-postagem {$prepostagem->object_code} marcada como postada.");
          } else {
            // Não foi postada, mas a requisição foi bem-sucedida.
            $this->line(" [ -- ] Pré-postagem {$prepostagem->object_code} ainda não postada.");
          }
        } else {
          Log::warning('Erro ao consultar postagem', [
            'object_code' => $prepostagem->object_code,
            'status' => $response->status(),
            'body' => $response->body(),
          ]);
          $this->warn(" [WARN] Erro ao consultar {$prepostagem->object_code}. Status: {$response->status()}");
        }
      } catch (\Exception $e) {
        Log::error('Erro ao verificar pré-postagem.', [
          'prepostagem_id' => $prepostagem->id,
          'error' => $e->getMessage(),
        ]);
        $this->error(" [ERRO] Exceção ao verificar {$prepostagem->object_code}: {$e->getMessage()}");
      }
    }

    Log::info('Verificação de pré-postagens concluída.');
    $this->info('Verificação de pré-postagens concluída.');
    return Command::SUCCESS;
  }
}

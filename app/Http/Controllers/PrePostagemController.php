<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrePostagemRequest;
use App\Models\Prepostagem;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\CorreiosToken;
use App\Models\Range;

class PrePostagemController extends Controller
{
  public function index()
{
    // 1. Buscar o token
    $token = CorreiosToken::latest()->first();

    if (!$token) {
        Log::warning('Token dos Correios não encontrado ao abrir index.');
        // Você pode decidir retornar aqui ou continuar exibindo pré-postagens sem atualizar status
    } else {
        // 2. Buscar todas pré-postagens com situation = 1 para verificar
        $prepostagens = Prepostagem::where('situation', 1)->get();

        foreach ($prepostagens as $prepostagem) {
            try {
                $response = Http::withoutVerifying()
                    ->withToken($token->token)
                    ->get("https://api.correios.com.br/prepostagem/v1/prepostagens/postada", [
                        'codigoObjeto' => $prepostagem->object_code,
                    ]);

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data['dataPostagem'])) {
                        $prepostagem->update(['situation' => 3]);

                        Log::info("Pré-postagem marcada como postada.", [
                            'object_code' => $prepostagem->object_code,
                            'prepostagem_id' => $prepostagem->id,
                            'dataPostagem' => $data['dataPostagem'],
                        ]);
                    }
                } else {
                    Log::warning('Erro ao consultar postagem', [
                        'object_code' => $prepostagem->object_code,
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Erro ao verificar pré-postagem.', [
                    'prepostagem_id' => $prepostagem->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        Log::info('Verificação de pré-postagens concluída.');
    }

    // 3. Buscar novamente as pré-postagens atualizadas para exibir na view
    $prepostagens = Prepostagem::orderBy('id', 'DESC')
        ->where('situation', 1)
        ->paginate(50);

    Log::info('Listar as Pré-Postagem.', ['action_user_id' => Auth::id()]);

    return view('prepostagens.index', ['prepostagens' => $prepostagens]);
}


    // Listar as Pré-Postagem canceladas
    public function canceled()
    {
        // Recuperar os registros do banco dados
        $prepostagens = Prepostagem::orderBy('id', 'DESC')
        ->where('situation', 2)
        ->paginate(50);

        // Salvar log
        Log::info('Listar as Pré-Postagem canceladas.', ['action_user_id' => Auth::id()]);

        // Carregar a view 
        return view('prepostagens.canceled', ['prepostagens' => $prepostagens]);
    }

    // Listar as Pré-Postagem postadas
    public function posted()
    {
        // Recuperar os registros do banco dados
        $prepostagens = Prepostagem::orderBy('id', 'ASC')
        ->where('situation', 3)
        ->paginate(50);

        // Salvar log
        Log::info('Listar as Pré-Postagem postadas.', ['action_user_id' => Auth::id()]);

        // Carregar a view 
        return view('prepostagens.posted', ['prepostagens' => $prepostagens]);
    }

    // Visualizar os detalhes das Pré-Postagens
    public function show(Prepostagem $prepostagem)
    {
        // Salvar log
        Log::info('Visualizar a Pré-Postagem.', ['prepostagem_id' => $prepostagem->id, 'action_user_id' => Auth::id()]);

        // Carregar a view 
        return view('prepostagens.show', ['prepostagem' => $prepostagem]);
    }

    // Carregar o formulário cadastrar nova Pré-Postagem
    public function create()
    {
        // Carregar a view 
        return view('prepostagens.create');
    }

public function store(PrePostagemRequest $request)
{
    try {
        $correiosToken = CorreiosToken::latest()->first();
        if (!$correiosToken) {
            throw new Exception("Token dos Correios não encontrado.");
        }

        // Apenas verificar se a etiqueta está disponível
        $etiqueta = Range::where('object_code', $request->object_code)
            ->where('used', 0)
            ->first();

        if (!$etiqueta) {
            Log::warning('Etiqueta não disponível para uso.', ['object_code' => $request->object_code]);
            return back()->withInput()->with('error', 'Etiqueta já utilizada ou não disponível no range.');
        }

        // Montar o payload da pré-postagem
        $payload = [
            "remetente" => [
                "nome" => $request->name_sender,
                "cpfCnpj" => $request->cnpj_sender,
                "endereco" => [
                    "cep" => $request->cep_sender,
                    "logradouro" => $request->public_place_sender,
                    "numero" => $request->number_sender,
                    "bairro" => $request->neighborhood_sender ?? '',
                    "cidade" => $request->city_sender,
                    "uf" => $request->uf_sender,
                ]
            ],
            "destinatario" => [
                "nome" => $request->name_recipient,
                "cpfCnpj" => $request->cnpj_recipient ?? '',
                "endereco" => [
                    "cep" => $request->cep_recipient,
                    "logradouro" => $request->public_place_recipient,
                    "numero" => $request->number_recipient,
                    "complemento" => $request->complement_recipient ?? '',
                    "bairro" => $request->neighborhood_recipient ?? '',
                    "cidade" => $request->city_recipient,
                    "uf" => $request->uf_recipient,
                ]
            ],
            "codigoServico" => $request->code_service,
            "codigoObjeto" => $request->object_code,
            "numeroNotaFiscal" => $request->invoice_number,
            "chaveNFe" => $request->nfe_key,
            "pesoInformado" => $request->weight_informed,
            "codigoFormatoObjetoInformado" => $request->code_format_informed_object,
            "alturaInformada" => $request->height_informed,
            "larguraInformada" => $request->width_informed,
            "comprimentoInformado" => $request->length_informed,
            "cienteObjetoNaoProibido" => $request->aware_object_not_forbidden,
            "modalidadePagamento" => $request->payment_method,
            'observacao' => $request->observation ?? '',
        ];

        // Chamar API dos Correios
        $response = Http::withoutVerifying()
            ->withToken($correiosToken->token)
            ->post('https://api.correios.com.br/prepostagem/v1/prepostagens', $payload);

        if (!$response->successful()) {
            $erroDetalhado = json_decode($response->body(), true);
            $mensagens = $erroDetalhado['msgs'] ?? [$response->body()];
            $mensagemErro = implode("\n", $mensagens);

            Log::warning('Falha ao enviar Pré-Postagem à API dos Correios.', [
                'status' => $response->status(),
                'erro' => $response->body()
            ]);

            return back()->withInput()->with('error', "Erro ao enviar Pré-Postagem: $mensagemErro");
        }

        // Salvar no banco de dados
        $prepostagem = Prepostagem::create([
            'name_sender' => $request->name_sender,
            'cnpj_sender' => $request->cnpj_sender,
            'cep_sender' => $request->cep_sender,
            'public_place_sender' => $request->public_place_sender,
            'number_sender' => $request->number_sender,
            'neighborhood_sender' => $request->neighborhood_sender,
            'city_sender' => $request->city_sender,
            'uf_sender' => $request->uf_sender,
            'name_recipient' => $request->name_recipient,
            'cnpj_recipient' => $request->cnpj_recipient,
            'cep_recipient' => $request->cep_recipient,
            'public_place_recipient' => $request->public_place_recipient,
            'number_recipient' => $request->number_recipient,
            'complement_recipient' => $request->complement_recipient,
            'neighborhood_recipient' => $request->neighborhood_recipient,
            'city_recipient' => $request->city_recipient,
            'uf_recipient' => $request->uf_recipient,
            'code_service' => $request->code_service,
            'object_code' => $request->object_code,
            'invoice_number' => $request->invoice_number,
            'nfe_key' => $request->nfe_key,
            'weight_informed' => $request->weight_informed,
            'code_format_informed_object' => $request->code_format_informed_object,
            'height_informed' => $request->height_informed,
            'width_informed' => $request->width_informed,
            'length_informed' => $request->length_informed,
            'diameter_informed' => $request->diameter_informed,
            'aware_object_not_forbidden' => $request->aware_object_not_forbidden,
            'payment_method' => $request->payment_method,
            'situation' => 1
        ]);

        $etiqueta->update(['used' => 1]);

        Log::info('Pré-Postagem enviada e cadastrada com sucesso.', [
            'prepostagem_id' => $prepostagem->id,
            'resposta_api' => $response->json()
        ]);

        return redirect()->route('prepostagens.show', ['prepostagem' => $prepostagem->id])
                         ->with('success', 'Pré-Postagem cadastrada com sucesso!');
    } catch (Exception $e) {
        Log::error('Erro ao cadastrar Pré-Postagem.', ['error' => $e->getMessage()]);
        return back()->withInput()->with('error', 'Erro interno ao tentar cadastrar Pré-Postagem.');
    }
}

    public function destroy(Prepostagem $prepostagem)
    {
        try {
            $correiosToken = CorreiosToken::latest()->first();

            if (!$correiosToken) {
                throw new Exception("Token dos Correios não encontrado.");
            }

            // Enviar requisição de cancelamento para a API dos Correios
            $response = Http::withoutVerifying()
                ->withToken($correiosToken->token)
                ->delete("https://api.correios.com.br/prepostagem/v1/prepostagens/objeto/{$prepostagem->object_code}");

            if (!$response->successful()) {
                Log::warning('Erro ao cancelar pré-postagem na API dos Correios.', [
                ]);

                return back()->with('error', 'Erro ao cancelar a pré-postagem na API dos Correios.');
            }

            // Atualizar a situação no banco para 2 = cancelada
            $prepostagem->update(['situation' => 2]);

            Log::info('Pré-Postagem cancelada com sucesso na API e atualizada no banco.', [
                'prepostagem_id' => $prepostagem->id,
                'action_user_id' => Auth::id()
            ]);

            return redirect()->route('prepostagens.index')->with('success', 'Pré-postagem cancelada com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao cancelar pré-postagem.', ['error' => $e->getMessage()]);

            return back()->with('error', 'Erro ao cancelar a pré-postagem.');
        }
    }
}

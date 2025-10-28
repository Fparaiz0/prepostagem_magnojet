<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrePostagemRequest;
use App\Models\CorreiosToken;
use App\Models\Prepostagem;
use App\Models\Range;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PrePostagemController extends Controller
{
  public function index(Request $request)
  {

    $token = CorreiosToken::latest()->first();

    if (!$token) {
      Log::warning('Token dos Correios não encontrado ao abrir index.');
    } else {

      $prepostagensParaVerificar = Prepostagem::where('situation', 1)->get();

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
            }
          } else {
            Log::warning('Erro ao consultar postagem', [
              'object_code' => $prepostagem->object_code,
              'status' => $response->status(),
              'body' => $response->body(),
            ]);
          }
        } catch (\Exception $e) {
          Log::error('Erro ao verificar pré-postagem.', [
            'prepostagem_id' => $prepostagem->id,
            'error' => $e->getMessage(),
          ]);
        }
      }

      Log::info('Verificação de pré-postagens concluída.');
    }

    $query = Prepostagem::orderBy('id', 'DESC')
      ->where('situation', 1);


    if ($request->has('search') && !empty($request->search)) {
      $searchTerm = $request->search;
      $query->where('name_recipient', 'like', '%' . $searchTerm . '%');
    }

    $prepostagens = $query->paginate(50);

    Log::info('Listar as Pré-Postagem.', ['action_user_id' => Auth::id()]);

    return view('prepostagens.index', [
      'prepostagens' => $prepostagens,
      'search' => $request->search,
    ]);
  }


  public function canceled(Request $request)
  {

    $query = Prepostagem::orderBy('id', 'DESC')
      ->where('situation', 2);


    if ($request->has('search') && !empty($request->search)) {
      $searchTerm = $request->search;
      $query->where('name_recipient', 'like', '%' . $searchTerm . '%');
    }

    $prepostagens = $query->paginate(50);


    Log::info('Listar as Pré-Postagem canceladas.', ['action_user_id' => Auth::id()]);


    return view('prepostagens.canceled', [
      'prepostagens' => $prepostagens,
      'search' => $request->search,
    ]);
  }


  public function posted(Request $request)
  {

    $query = Prepostagem::orderBy('id', 'DESC')
      ->where('situation', 3);


    if ($request->has('search') && !empty($request->search)) {
      $searchTerm = $request->search;
      $query->where('name_recipient', 'like', '%' . $searchTerm . '%');
    }

    $prepostagens = $query->paginate(50);

    Log::info('Listar as Pré-Postagem postadas.', ['action_user_id' => Auth::id()]);

    return view('prepostagens.posted', [
      'prepostagens' => $prepostagens,
      'search' => $request->search,
    ]);
  }


  public function show(Prepostagem $prepostagem)
  {

    Log::info('Visualizar a Pré-Postagem.', ['prepostagem_id' => $prepostagem->id, 'action_user_id' => Auth::id()]);


    return view('prepostagens.show', ['prepostagem' => $prepostagem]);
  }


  public function create()
  {

    return view('prepostagens.create');
  }

  public function store(PrePostagemRequest $request)
  {
    try {
      $correiosToken = CorreiosToken::latest()->first();
      if (!$correiosToken) {
        throw new Exception('Token dos Correios não encontrado.');
      }


      $etiqueta = Range::where('object_code', $request->object_code)
        ->where('used', 0)
        ->first();

      if (!$etiqueta) {
        Log::warning('Etiqueta não disponível para uso.', ['object_code' => $request->object_code]);

        return back()->withInput()->with('error', 'Etiqueta já utilizada ou não disponível no range.');
      }

      $payload = [
        'remetente' => [
          'nome' => $request->name_sender,
          'cpfCnpj' => $request->cnpj_sender,
          'endereco' => [
            'cep' => $request->cep_sender,
            'logradouro' => $request->public_place_sender,
            'numero' => $request->number_sender,
            'bairro' => $request->neighborhood_sender ?? '',
            'cidade' => $request->city_sender,
            'uf' => $request->uf_sender,
          ],
        ],
        'destinatario' => [
          'nome' => $request->name_recipient,
          'cpfCnpj' => $request->cnpj_recipient ?? '',
          'endereco' => [
            'cep' => $request->cep_recipient,
            'logradouro' => $request->public_place_recipient,
            'numero' => $request->number_recipient,
            'complemento' => $request->complement_recipient ?? '',
            'bairro' => $request->neighborhood_recipient ?? '',
            'cidade' => $request->city_recipient,
            'uf' => $request->uf_recipient,
          ],
        ],
        'itensDeclaracaoConteudo' => [
          [
            'conteudo' => 'Equipamentos - ITENS NÃO PERIGOSOS',
            'quantidade' => '1',
            'peso' => '1000',
            'valor' => '0.00',
          ],
        ],
        'codigoServico' => '03220',
        'codigoObjeto' => $request->object_code,
        'numeroNotaFiscal' => $request->invoice_number,
        'chaveNFe' => $request->nfe_key,
        'pesoInformado' => $request->weight_informed,
        'codigoFormatoObjetoInformado' => $request->code_format_informed_object,
        'alturaInformada' => $request->height_informed,
        'larguraInformada' => $request->width_informed,
        'comprimentoInformado' => $request->length_informed,
        'cienteObjetoNaoProibido' => '1',
        'modalidadePagamento' => '2',
        'observacao' => $request->observation ?? '',
      ];


      $response = Http::withToken($correiosToken->token)
        ->post('https://api.correios.com.br/prepostagem/v1/prepostagens', $payload);

      if (!$response->successful()) {
        $erroDetalhado = json_decode($response->body(), true);
        $mensagens = $erroDetalhado['msgs'] ?? [$response->body()];
        $mensagemErro = implode("\n", $mensagens);

        Log::warning('Falha ao enviar Pré-Postagem à API dos Correios.', [
          'Requisicao' => $payload,
          'status' => $response->status(),
          'erro' => $response->body(),
        ]);

        return back()->withInput()->with('error', "Erro ao enviar Pré-Postagem: $mensagemErro");
      }


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
        'code_service' => '03220',
        'object_code' => $request->object_code,
        'invoice_number' => $request->invoice_number,
        'nfe_key' => $request->nfe_key,
        'weight_informed' => $request->weight_informed,
        'code_format_informed_object' => $request->code_format_informed_object,
        'height_informed' => $request->height_informed,
        'width_informed' => $request->width_informed,
        'length_informed' => $request->length_informed,
        'diameter_informed' => $request->diameter_informed,
        'aware_object_not_forbidden' => '1',
        'payment_method' => '2',
        'observation' => $request->observation ?? '',
        'situation' => 1,
      ]);

      $etiqueta->update(['used' => 1]);

      Log::info('Pré-Postagem enviada e cadastrada com sucesso.', [
        'prepostagem_id' => $prepostagem->id,
        'resposta_api' => $response->json(),
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
        throw new Exception('Token dos Correios não encontrado.');
      }

      $response = Http::withToken($correiosToken->token)
        ->delete("https://api.correios.com.br/prepostagem/v1/prepostagens/objeto/{$prepostagem->object_code}");

      if (!$response->successful()) {
        Log::warning('Erro ao cancelar pré-postagem na API dos Correios.', [
          'prepostagem_id' => $prepostagem->id,
          'action_user_id' => Auth::id(),
          $response,
        ]);

        return back()->with('error', 'Erro ao cancelar a pré-postagem na API dos Correios.');
      }

      $prepostagem->update(['situation' => 2]);

      Log::info('Pré-Postagem cancelada com sucesso na API e atualizada no banco.', [
        'prepostagem_id' => $prepostagem->id,
        'action_user_id' => Auth::id(),
      ]);

      return redirect()->route('prepostagens.index')->with('success', 'Pré-postagem cancelada com sucesso!');
    } catch (Exception $e) {
      Log::error('Erro ao cancelar pré-postagem.', ['error' => $e->getMessage()]);

      return back()->with('error', 'Erro ao cancelar a pré-postagem.');
    }
  }

  public function imprimirSelecionados(Request $request)
  {
    try {
      $correiosToken = CorreiosToken::latest()->first();

      if (!$correiosToken) {
        Log::error('Token dos Correios não encontrado para impressão de etiquetas.');

        return response()->json([
          'error' => 'Token de autenticação não configurado',
          'message' => 'Token dos Correios não encontrado. Entre em contato com o administrador.',
        ], 500);
      }

      $validated = $request->validate([
        'codigosObjeto' => 'required|array|min:1',
        'codigosObjeto.*' => 'required|string|size:13',
        'formato' => 'required|string|in:etiqueta,a4',
      ]);

      $layoutImpressao = $this->getLayoutImpressao($validated['formato']);

      $payload = [
        'codigosObjeto' => $validated['codigosObjeto'],
        'idCorreios' => 'magno2016',
        'numeroCartaoPostagem' => '0067038727',
        'tipoRotulo' => 'P',
        'imprimeRemetente' => 'S',
        'layoutImpressao' => $layoutImpressao,
      ];

      Log::info('Enviando requisição para API dos Correios - Impressão de etiquetas selecionadas', [
        'quantidade_codigos' => count($validated['codigosObjeto']),
        'codigos_objeto' => $validated['codigosObjeto'],
        'formato' => $validated['formato'],
        'layout_impressao' => $layoutImpressao,
        'payload' => $payload,
      ]);

      $response = Http::timeout(30)
        ->withToken($correiosToken->token)
        ->withHeaders([
          'Content-Type' => 'application/json',
          'Accept' => 'application/json',
        ])
        ->post('https://api.correios.com.br/prepostagem/v1/prepostagens/rotulo/assincrono/pdf', $payload);

      if (!$response->successful()) {
        $statusCode = $response->status();
        $errorBody = $response->body();

        Log::error('Erro na API dos Correios - Impressão de etiquetas selecionadas', [
          'status_code' => $statusCode,
          'response_body' => $errorBody,
          'quantidade_codigos' => count($validated['codigosObjeto']),
          'formato' => $validated['formato'],
        ]);

        $errorMessages = ['Erro ao processar a requisição dos Correios'];
        try {
          $errorData = json_decode($errorBody, true);
          if (isset($errorData['msgs']) && is_array($errorData['msgs'])) {
            $errorMessages = $errorData['msgs'];
          } elseif (isset($errorData['message'])) {
            $errorMessages = [$errorData['message']];
          }
        } catch (\Exception $e) {

        }

        return response()->json([
          'error' => 'Erro na API dos Correios',
          'message' => implode(', ', $errorMessages),
          'status_code' => $statusCode,
        ], $statusCode);
      }

      $responseData = $response->json();

      Log::info('Resposta recebida da API dos Correios - Impressão de etiquetas selecionadas', [
        'response_data' => $responseData,
        'quantidade_codigos' => count($validated['codigosObjeto']),
        'formato' => $validated['formato'],
      ]);

      if (!isset($responseData['idRecibo'])) {
        Log::warning('Resposta da API dos Correios não contém ID do recibo', [
          'response_data' => $responseData,
        ]);

        return response()->json([
          'error' => 'Resposta inválida da API',
          'message' => 'A resposta da API não contém o ID do recibo esperado.',
        ], 500);
      }

      $idRecibo = $responseData['idRecibo'];

      $maxTentativas = 5;
      $tentativa = 1;
      $pdfContent = null;
      $fileName = null;

      while ($tentativa <= $maxTentativas) {
        Log::info('Tentativa ' . $tentativa . ' de buscar PDF do rótulo usando idRecibo', [
          'idRecibo' => $idRecibo,
          'formato' => $validated['formato'],
        ]);

        try {
          $pdfResponse = Http::timeout(30)
            ->withToken($correiosToken->token)
            ->withHeaders([
              'Accept' => 'application/json',
            ])
            ->get("https://api.correios.com.br/prepostagem/v1/prepostagens/rotulo/download/assincrono/{$idRecibo}");

          if ($pdfResponse->successful()) {
            $pdfData = $pdfResponse->json();

            if (isset($pdfData['dados'])) {
              $pdfContent = base64_decode($pdfData['dados']);
              $fileName = $pdfData['nome'] ?? "etiquetas_selecionadas_{$idRecibo}.pdf";

              if ($pdfContent) {
                Log::info('PDF de etiquetas selecionadas gerado com sucesso na tentativa ' . $tentativa, [
                  'idRecibo' => $idRecibo,
                  'fileName' => $fileName,
                  'pdfSize' => strlen($pdfContent),
                  'quantidade_etiquetas' => count($validated['codigosObjeto']),
                  'formato' => $validated['formato'],
                ]);
                break;
              }
            }
          }

          if ($tentativa === $maxTentativas) {
            Log::error('Erro ao buscar PDF do rótulo após ' . $maxTentativas . ' tentativas', [
              'idRecibo' => $idRecibo,
              'status_code' => $pdfResponse->status(),
              'response_body' => $pdfResponse->body(),
              'formato' => $validated['formato'],
            ]);

            return response()->json([
              'error' => 'Erro ao gerar PDF',
              'message' => 'Não foi possível gerar o PDF após várias tentativas. Tente novamente mais tarde.',
              'idRecibo' => $idRecibo,
            ], 500);
          }

        } catch (\Exception $e) {
          if ($tentativa === $maxTentativas) {
            Log::error('Exceção ao buscar PDF do rótulo na tentativa ' . $tentativa, [
              'idRecibo' => $idRecibo,
              'error' => $e->getMessage(),
              'formato' => $validated['formato'],
            ]);

            return response()->json([
              'error' => 'Erro ao processar PDF',
              'message' => 'Ocorreu um erro interno ao tentar gerar o PDF.',
            ], 500);
          }
        }

        sleep(2);
        $tentativa++;
      }

      return response($pdfContent)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', "inline; filename=\"{$fileName}\"")
        ->header('Content-Length', strlen($pdfContent));

    } catch (\Illuminate\Validation\ValidationException $e) {
      Log::warning('Validação falhou para impressão de etiquetas selecionadas', [
        'errors' => $e->errors(),
      ]);

      return response()->json([
        'error' => 'Dados inválidos',
        'message' => 'Os dados fornecidos são inválidos.',
        'errors' => $e->errors(),
      ], 422);

    } catch (\Exception $e) {
      Log::error('Erro interno ao processar impressão de etiquetas selecionadas', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
      ]);

      return response()->json([
        'error' => 'Erro interno do servidor',
        'message' => 'Ocorreu um erro interno ao processar a solicitação.',
      ], 500);
    }
  }

  /**
   * Imprimir todas as pré-postagens com situation = 1
   */
  public function imprimirTodas(Request $request)
  {
    try {
      $correiosToken = CorreiosToken::latest()->first();

      if (!$correiosToken) {
        Log::error('Token dos Correios não encontrado para impressão de todas as etiquetas.');

        return response()->json([
          'error' => 'Token de autenticação não configurado',
          'message' => 'Token dos Correios não encontrado. Entre em contato com o administrador.',
        ], 500);
      }

      $validated = $request->validate([
        'formato' => 'required|string|in:etiqueta,a4',
      ]);

      $formato = $validated['formato'];

      $prepostagens = Prepostagem::where('situation', 1)->get();

      if ($prepostagens->isEmpty()) {
        Log::warning('Nenhuma pré-postagem encontrada para impressão', [
          'situation' => 1,
          'formato' => $formato,
        ]);

        return response()->json([
          'error' => 'Nenhuma pré-postagem encontrada',
          'message' => 'Não há pré-postagens pendentes para impressão.',
        ], 404);
      }

      $codigosObjeto = $prepostagens->pluck('object_code')->toArray();

      $layoutImpressao = $this->getLayoutImpressao($formato);

      Log::info('Imprimindo todas as pré-postagens pendentes', [
        'quantidade' => count($codigosObjeto),
        'codigos_objeto' => $codigosObjeto,
        'formato' => $formato,
        'layout_impressao' => $layoutImpressao,
      ]);

      $payload = [
        'codigosObjeto' => $codigosObjeto,
        'idCorreios' => 'magno2016',
        'numeroCartaoPostagem' => '0067038727',
        'tipoRotulo' => 'P',
        'imprimeRemetente' => 'S',
        'layoutImpressao' => $layoutImpressao,
      ];

      $response = Http::timeout(30)
        ->withToken($correiosToken->token)
        ->withHeaders([
          'Content-Type' => 'application/json',
          'Accept' => 'application/json',
        ])
        ->post('https://api.correios.com.br/prepostagem/v1/prepostagens/rotulo/assincrono/pdf', $payload);

      if (!$response->successful()) {
        $statusCode = $response->status();
        $errorBody = $response->body();

        Log::error('Erro na API dos Correios - Impressão de todas as etiquetas', [
          'status_code' => $statusCode,
          'response_body' => $errorBody,
          'quantidade_codigos' => count($codigosObjeto),
          'formato' => $formato,
        ]);

        $errorMessages = ['Erro ao processar a requisição dos Correios'];
        try {
          $errorData = json_decode($errorBody, true);
          if (isset($errorData['msgs']) && is_array($errorData['msgs'])) {
            $errorMessages = $errorData['msgs'];
          } elseif (isset($errorData['message'])) {
            $errorMessages = [$errorData['message']];
          }
        } catch (\Exception $e) {
        }

        return response()->json([
          'error' => 'Erro na API dos Correios',
          'message' => implode(', ', $errorMessages),
          'status_code' => $statusCode,
        ], $statusCode);
      }

      $responseData = $response->json();

      Log::info('Resposta recebida da API dos Correios - Impressão de todas as etiquetas', [
        'response_data' => $responseData,
        'quantidade_codigos' => count($codigosObjeto),
        'formato' => $formato,
      ]);

      if (!isset($responseData['idRecibo'])) {
        Log::warning('Resposta da API dos Correios não contém ID do recibo', [
          'response_data' => $responseData,
        ]);

        return response()->json([
          'error' => 'Resposta inválida da API',
          'message' => 'A resposta da API não contém o ID do recibo esperado.',
        ], 500);
      }

      $idRecibo = $responseData['idRecibo'];

      $maxTentativas = 5;
      $tentativa = 1;
      $pdfContent = null;
      $fileName = null;

      while ($tentativa <= $maxTentativas) {
        Log::info('Tentativa ' . $tentativa . ' de buscar PDF do rótulo usando idRecibo', [
          'idRecibo' => $idRecibo,
          'formato' => $formato,
        ]);

        try {
          $pdfResponse = Http::timeout(30)
            ->withToken($correiosToken->token)
            ->withHeaders([
              'Accept' => 'application/json',
            ])
            ->get("https://api.correios.com.br/prepostagem/v1/prepostagens/rotulo/download/assincrono/{$idRecibo}");

          if ($pdfResponse->successful()) {
            $pdfData = $pdfResponse->json();

            if (isset($pdfData['dados'])) {
              $pdfContent = base64_decode($pdfData['dados']);
              $fileName = $pdfData['nome'] ?? "etiquetas_todas_{$idRecibo}.pdf";

              if ($pdfContent) {
                Log::info('PDF de todas as etiquetas gerado com sucesso na tentativa ' . $tentativa, [
                  'idRecibo' => $idRecibo,
                  'fileName' => $fileName,
                  'pdfSize' => strlen($pdfContent),
                  'quantidade_etiquetas' => count($codigosObjeto),
                  'formato' => $formato,
                ]);
                break;
              }
            }
          }

          if ($tentativa === $maxTentativas) {
            Log::error('Erro ao buscar PDF do rótulo após ' . $maxTentativas . ' tentativas', [
              'idRecibo' => $idRecibo,
              'status_code' => $pdfResponse->status(),
              'response_body' => $pdfResponse->body(),
              'formato' => $formato,
            ]);

            return response()->json([
              'error' => 'Erro ao gerar PDF',
              'message' => 'Não foi possível gerar o PDF após várias tentativas. Tente novamente mais tarde.',
              'idRecibo' => $idRecibo,
            ], 500);
          }

        } catch (\Exception $e) {
          if ($tentativa === $maxTentativas) {
            Log::error('Exceção ao buscar PDF do rótulo na tentativa ' . $tentativa, [
              'idRecibo' => $idRecibo,
              'error' => $e->getMessage(),
              'formato' => $formato,
            ]);

            return response()->json([
              'error' => 'Erro ao processar PDF',
              'message' => 'Ocorreu um erro interno ao tentar gerar o PDF.',
            ], 500);
          }
        }

        sleep(2);
        $tentativa++;
      }

      return response($pdfContent)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', "inline; filename=\"{$fileName}\"")
        ->header('Content-Length', strlen($pdfContent));

    } catch (\Illuminate\Validation\ValidationException $e) {
      Log::warning('Validação falhou para impressão de todas as etiquetas', [
        'errors' => $e->errors(),
      ]);

      return response()->json([
        'error' => 'Dados inválidos',
        'message' => 'Os dados fornecidos são inválidos.',
        'errors' => $e->errors(),
      ], 422);

    } catch (\Exception $e) {
      Log::error('Erro interno ao processar impressão de todas as etiquetas', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
      ]);

      return response()->json([
        'error' => 'Erro interno do servidor',
        'message' => 'Ocorreu um erro interno ao processar a solicitação.',
      ], 500);
    }
  }

  private function getLayoutImpressao(string $formato): string
  {
    return match ($formato) {
      'a4' => 'PADRAO',
      'etiqueta' => 'LINEAR_100_150',
      default => 'LINEAR_100_150',
    };
  }
}
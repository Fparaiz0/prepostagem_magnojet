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
        // 1. Buscar o token
        $token = CorreiosToken::latest()->first();

        if (! $token) {
            Log::warning('Token dos Correios não encontrado ao abrir index.');
        } else {
            // 2. Buscar todas pré-postagens com situation = 1 para verificar
            $prepostagensParaVerificar = Prepostagem::where('situation', 1)->get();

            foreach ($prepostagensParaVerificar as $prepostagem) {
                try {
                    $response = Http::withoutVerifying()
                        ->withToken($token->token)
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

        // Adicionar filtro de pesquisa se existir
        if ($request->has('search') && ! empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name_recipient', 'like', '%'.$searchTerm.'%');
        }

        $prepostagens = $query->paginate(50);

        Log::info('Listar as Pré-Postagem.', ['action_user_id' => Auth::id()]);

        return view('prepostagens.index', [
            'prepostagens' => $prepostagens,
            'search' => $request->search, // Passar o termo de pesquisa para a view
        ]);
    }

    // Listar as Pré-Postagem canceladas
    public function canceled(Request $request)
    {
        // Recuperar os registros do banco dados
        $query = Prepostagem::orderBy('id', 'DESC')
            ->where('situation', 2);

        // Adicionar filtro de pesquisa se existir
        if ($request->has('search') && ! empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name_recipient', 'like', '%'.$searchTerm.'%');
        }

        $prepostagens = $query->paginate(50);

        // Salvar log
        Log::info('Listar as Pré-Postagem canceladas.', ['action_user_id' => Auth::id()]);

        // Carregar a view
        return view('prepostagens.canceled', [
            'prepostagens' => $prepostagens,
            'search' => $request->search,
        ]);
    }

    // Listar as Pré-Postagem postadas
    public function posted(Request $request)
    {
        // Recuperar os registros do banco dados
        $query = Prepostagem::orderBy('id', 'DESC')
            ->where('situation', 3);

        // Adicionar filtro de pesquisa se existir
        if ($request->has('search') && ! empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name_recipient', 'like', '%'.$searchTerm.'%');
        }

        $prepostagens = $query->paginate(50);

        // Salvar log
        Log::info('Listar as Pré-Postagem postadas.', ['action_user_id' => Auth::id()]);

        // Carregar a view
        return view('prepostagens.posted', [
            'prepostagens' => $prepostagens,
            'search' => $request->search,
        ]);
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
            if (! $correiosToken) {
                throw new Exception('Token dos Correios não encontrado.');
            }

            // Apenas verificar se a etiqueta está disponível
            $etiqueta = Range::where('object_code', $request->object_code)
                ->where('used', 0)
                ->first();

            if (! $etiqueta) {
                Log::warning('Etiqueta não disponível para uso.', ['object_code' => $request->object_code]);

                return back()->withInput()->with('error', 'Etiqueta já utilizada ou não disponível no range.');
            }

            // Montar o payload da pré-postagem
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

            // Chamar API dos Correios
            $response = Http::withoutVerifying()
                ->withToken($correiosToken->token)
                ->post('https://api.correios.com.br/prepostagem/v1/prepostagens', $payload);

            if (! $response->successful()) {
                $erroDetalhado = json_decode($response->body(), true);
                $mensagens = $erroDetalhado['msgs'] ?? [$response->body()];
                $mensagemErro = implode("\n", $mensagens);

                Log::warning('Falha ao enviar Pré-Postagem à API dos Correios.', [
                    'status' => $response->status(),
                    'erro' => $response->body(),
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

            if (! $correiosToken) {
                throw new Exception('Token dos Correios não encontrado.');
            }

            // Enviar requisição de cancelamento para a API dos Correios
            $response = Http::withoutVerifying()
                ->withToken($correiosToken->token)
                ->delete("https://api.correios.com.br/prepostagem/v1/prepostagens/objeto/{$prepostagem->object_code}");

            if (! $response->successful()) {
                Log::warning('Erro ao cancelar pré-postagem na API dos Correios.', [
                    'prepostagem_id' => $prepostagem->id,
                    'action_user_id' => Auth::id(),
                    $response,
                ]);

                return back()->with('error', 'Erro ao cancelar a pré-postagem na API dos Correios.');
            }

            // Atualizar a situação no banco para 2 = cancelada
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

    /**
     * Imprimir etiquetas selecionadas via API dos Correios
     */
    public function imprimirSelecionados(Request $request)
    {
        try {
            $correiosToken = CorreiosToken::latest()->first();

            if (! $correiosToken) {
                Log::error('Token dos Correios não encontrado para impressão de etiquetas.');

                return response()->json([
                    'error' => 'Token de autenticação não configurado',
                    'message' => 'Token dos Correios não encontrado. Entre em contato com o administrador.',
                ], 500);
            }

            // Validar os dados recebidos
            $validated = $request->validate([
                'codigosObjeto' => 'required|array|min:1',
                'codigosObjeto.*' => 'required|string|size:13', // Códigos de objeto têm 13 caracteres
            ]);

            // Montar o payload conforme especificado pela API dos Correios
            $payload = [
                'codigosObjeto' => $validated['codigosObjeto'],
                'idCorreios' => 'magno2016',
                'numeroCartaoPostagem' => '0067038727',
                'tipoRotulo' => 'P',
                'imprimeRemetente' => 'S',
                'layoutImpressao' => 'PADRAO',
            ];

            Log::info('Enviando requisição para API dos Correios - Impressão de etiquetas', [
                'codigos_objeto' => $validated['codigosObjeto'],
                'payload' => $payload,
            ]);

            // Chamar API dos Correios para impressão de etiquetas
            $response = Http::withoutVerifying()
                ->timeout(30) // Timeout de 30 segundos
                ->withToken($correiosToken->token)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post('https://api.correios.com.br/prepostagem/v1/prepostagens/rotulo/assincrono/pdf', $payload);

            // Verificar se a requisição foi bem sucedida
            if (! $response->successful()) {
                $statusCode = $response->status();
                $errorBody = $response->body();

                Log::error('Erro na API dos Correios - Impressão de etiquetas', [
                    'status_code' => $statusCode,
                    'response_body' => $errorBody,
                    'codigos_objeto' => $validated['codigosObjeto'],
                ]);

                // Tentar extrair mensagens de erro da resposta
                $errorMessages = ['Erro ao processar a requisição dos Correios'];
                try {
                    $errorData = json_decode($errorBody, true);
                    if (isset($errorData['msgs']) && is_array($errorData['msgs'])) {
                        $errorMessages = $errorData['msgs'];
                    } elseif (isset($errorData['message'])) {
                        $errorMessages = [$errorData['message']];
                    }
                } catch (\Exception $e) {
                    // Manter a mensagem padrão se não conseguir decodificar JSON
                }

                return response()->json([
                    'error' => 'Erro na API dos Correios',
                    'message' => implode(', ', $errorMessages),
                    'status_code' => $statusCode,
                ], $statusCode);
            }

            // Processar resposta bem-sucedida
            $responseData = $response->json();

            Log::info('Resposta recebida da API dos Correios - Impressão de etiquetas', [
                'response_data' => $responseData,
                'codigos_objeto' => $validated['codigosObjeto'],
            ]);

            // Verificar se a resposta contém o ID do recibo
            if (! isset($responseData['idRecibo'])) {
                Log::warning('Resposta da API dos Correios não contém ID do recibo', [
                    'response_data' => $responseData,
                ]);

                return response()->json([
                    'error' => 'Resposta inválida da API',
                    'message' => 'A resposta da API não contém o ID do recibo esperado.',
                ], 500);
            }

            $idRecibo = $responseData['idRecibo'];

            // Agora fazer a segunda requisição para buscar o PDF usando o idRecibo
            // TENTAR ATÉ 5 VEZES COM INTERVALO DE 2 SEGUNDOS
            $maxTentativas = 5;
            $tentativa = 1;
            $pdfContent = null;
            $fileName = null;

            while ($tentativa <= $maxTentativas) {
                Log::info('Tentativa '.$tentativa.' de buscar PDF do rótulo usando idRecibo', ['idRecibo' => $idRecibo]);

                try {
                    $pdfResponse = Http::withoutVerifying()
                        ->timeout(30) // Timeout de 30 segundos por tentativa
                        ->withToken($correiosToken->token)
                        ->withHeaders([
                            'Accept' => 'application/json',
                        ])
                        ->get("https://api.correios.com.br/prepostagem/v1/prepostagens/rotulo/download/assincrono/{$idRecibo}");

                    if ($pdfResponse->successful()) {
                        // Processar resposta do PDF
                        $pdfData = $pdfResponse->json();

                        // Verificar se a resposta contém os dados do PDF em base64
                        if (isset($pdfData['dados'])) {
                            // Decodificar o PDF base64
                            $pdfContent = base64_decode($pdfData['dados']);
                            $fileName = $pdfData['nome'] ?? "etiquetas_{$idRecibo}.pdf";

                            if ($pdfContent) {
                                Log::info('PDF gerado com sucesso na tentativa '.$tentativa, [
                                    'idRecibo' => $idRecibo,
                                    'fileName' => $fileName,
                                    'pdfSize' => strlen($pdfContent),
                                ]);
                                break; // Sai do loop se conseguir obter o PDF
                            }
                        }
                    }

                    // Se não conseguiu na última tentativa, loga o erro
                    if ($tentativa === $maxTentativas) {
                        Log::error('Erro ao buscar PDF do rótulo após '.$maxTentativas.' tentativas', [
                            'idRecibo' => $idRecibo,
                            'status_code' => $pdfResponse->status(),
                            'response_body' => $pdfResponse->body(),
                        ]);

                        return response()->json([
                            'error' => 'Erro ao gerar PDF',
                            'message' => 'Não foi possível gerar o PDF após várias tentativas. Tente novamente mais tarde.',
                            'idRecibo' => $idRecibo,
                        ], 500);
                    }

                } catch (\Exception $e) {
                    // Se for a última tentativa e ainda deu erro, lança a exceção
                    if ($tentativa === $maxTentativas) {
                        Log::error('Exceção ao buscar PDF do rótulo na tentativa '.$tentativa, [
                            'idRecibo' => $idRecibo,
                            'error' => $e->getMessage(),
                        ]);

                        return response()->json([
                            'error' => 'Erro ao processar PDF',
                            'message' => 'Ocorreu um erro interno ao tentar gerar o PDF.',
                        ], 500);
                    }
                }

                // Aguarda 2 segundos antes da próxima tentativa
                sleep(2);
                $tentativa++;
            }

            // Se chegou aqui, conseguiu obter o PDF com sucesso
            // Retornar o PDF como resposta
            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', "inline; filename=\"{$fileName}\"")
                ->header('Content-Length', strlen($pdfContent));

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validação falhou para impressão de etiquetas', [
                'errors' => $e->errors(),
            ]);

            return response()->json([
                'error' => 'Dados inválidos',
                'message' => 'Os dados fornecidos são inválidos.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erro interno ao processar impressão de etiquetas', [
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

            if (! $correiosToken) {
                Log::error('Token dos Correios não encontrado para impressão de todas as etiquetas.');

                return response()->json([
                    'error' => 'Token de autenticação não configurado',
                    'message' => 'Token dos Correios não encontrado. Entre em contato com o administrador.',
                ], 500);
            }

            // Buscar todas as pré-postagens com situation = 1
            $prepostagens = Prepostagem::where('situation', 1)->get();

            if ($prepostagens->isEmpty()) {
                Log::warning('Nenhuma pré-postagem encontrada para impressão', [
                    'situation' => 1,
                ]);

                return response()->json([
                    'error' => 'Nenhuma pré-postagem encontrada',
                    'message' => 'Não há pré-postagens pendentes para impressão.',
                ], 404);
            }

            // Extrair os códigos de objeto
            $codigosObjeto = $prepostagens->pluck('object_code')->toArray();

            Log::info('Imprimindo todas as pré-postagens pendentes', [
                'quantidade' => count($codigosObjeto),
                'codigos_objeto' => $codigosObjeto,
            ]);

            // Montar o payload conforme especificado pela API dos Correios
            $payload = [
                'codigosObjeto' => $codigosObjeto,
                'idCorreios' => 'magno2016',
                'numeroCartaoPostagem' => '0067038727',
                'tipoRotulo' => 'P',
                'imprimeRemetente' => 'S',
                'layoutImpressao' => 'PADRAO',
            ];

            // Chamar API dos Correios para impressão de etiquetas
            $response = Http::withoutVerifying()
                ->timeout(30) // Timeout de 30 segundos
                ->withToken($correiosToken->token)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post('https://api.correios.com.br/prepostagem/v1/prepostagens/rotulo/assincrono/pdf', $payload);

            // Verificar se a requisição foi bem sucedida
            if (! $response->successful()) {
                $statusCode = $response->status();
                $errorBody = $response->body();

                Log::error('Erro na API dos Correios - Impressão de todas as etiquetas', [
                    'status_code' => $statusCode,
                    'response_body' => $errorBody,
                    'codigos_objeto' => $codigosObjeto,
                ]);

                // Tentar extrair mensagens de erro da resposta
                $errorMessages = ['Erro ao processar a requisição dos Correios'];
                try {
                    $errorData = json_decode($errorBody, true);
                    if (isset($errorData['msgs']) && is_array($errorData['msgs'])) {
                        $errorMessages = $errorData['msgs'];
                    } elseif (isset($errorData['message'])) {
                        $errorMessages = [$errorData['message']];
                    }
                } catch (\Exception $e) {
                    // Manter a mensagem padrão se não conseguir decodificar JSON
                }

                return response()->json([
                    'error' => 'Erro na API dos Correios',
                    'message' => implode(', ', $errorMessages),
                    'status_code' => $statusCode,
                ], $statusCode);
            }

            // Processar resposta bem-sucedida
            $responseData = $response->json();

            Log::info('Resposta recebida da API dos Correios - Impressão de todas as etiquetas', [
                'response_data' => $responseData,
                'quantidade_codigos' => count($codigosObjeto),
            ]);

            // Verificar se a resposta contém o ID do recibo
            if (! isset($responseData['idRecibo'])) {
                Log::warning('Resposta da API dos Correios não contém ID do recibo', [
                    'response_data' => $responseData,
                ]);

                return response()->json([
                    'error' => 'Resposta inválida da API',
                    'message' => 'A resposta da API não contém o ID do recibo esperado.',
                ], 500);
            }

            $idRecibo = $responseData['idRecibo'];

            // TENTAR ATÉ 5 VEZES COM INTERVALO DE 2 SEGUNDOS
            $maxTentativas = 5;
            $tentativa = 1;
            $pdfContent = null;
            $fileName = null;

            while ($tentativa <= $maxTentativas) {
                Log::info('Tentativa '.$tentativa.' de buscar PDF do rótulo usando idRecibo', ['idRecibo' => $idRecibo]);

                try {
                    $pdfResponse = Http::withoutVerifying()
                        ->timeout(30) // Timeout de 30 segundos por tentativa
                        ->withToken($correiosToken->token)
                        ->withHeaders([
                            'Accept' => 'application/json',
                        ])
                        ->get("https://api.correios.com.br/prepostagem/v1/prepostagens/rotulo/download/assincrono/{$idRecibo}");

                    if ($pdfResponse->successful()) {
                        // Processar resposta do PDF
                        $pdfData = $pdfResponse->json();

                        // Verificar se a resposta contém os dados do PDF em base64
                        if (isset($pdfData['dados'])) {
                            // Decodificar o PDF base64
                            $pdfContent = base64_decode($pdfData['dados']);
                            $fileName = $pdfData['nome'] ?? "etiquetas_todas_{$idRecibo}.pdf";

                            if ($pdfContent) {
                                Log::info('PDF de todas as etiquetas gerado com sucesso na tentativa '.$tentativa, [
                                    'idRecibo' => $idRecibo,
                                    'fileName' => $fileName,
                                    'pdfSize' => strlen($pdfContent),
                                    'quantidade_etiquetas' => count($codigosObjeto),
                                ]);
                                break; // Sai do loop se conseguir obter o PDF
                            }
                        }
                    }

                    // Se não conseguiu na última tentativa, loga o erro
                    if ($tentativa === $maxTentativas) {
                        Log::error('Erro ao buscar PDF do rótulo após '.$maxTentativas.' tentativas', [
                            'idRecibo' => $idRecibo,
                            'status_code' => $pdfResponse->status(),
                            'response_body' => $pdfResponse->body(),
                        ]);

                        return response()->json([
                            'error' => 'Erro ao gerar PDF',
                            'message' => 'Não foi possível gerar o PDF após várias tentativas. Tente novamente mais tarde.',
                            'idRecibo' => $idRecibo,
                        ], 500);
                    }

                } catch (\Exception $e) {
                    // Se for a última tentativa e ainda deu erro, lança a exceção
                    if ($tentativa === $maxTentativas) {
                        Log::error('Exceção ao buscar PDF do rótulo na tentativa '.$tentativa, [
                            'idRecibo' => $idRecibo,
                            'error' => $e->getMessage(),
                        ]);

                        return response()->json([
                            'error' => 'Erro ao processar PDF',
                            'message' => 'Ocorreu um erro interno ao tentar gerar o PDF.',
                        ], 500);
                    }
                }

                // Aguarda 2 segundos antes da próxima tentativa
                sleep(2);
                $tentativa++;
            }

            // Se chegou aqui, conseguiu obter o PDF com sucesso
            // Retornar o PDF como resposta
            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', "inline; filename=\"{$fileName}\"")
                ->header('Content-Length', strlen($pdfContent));

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
}

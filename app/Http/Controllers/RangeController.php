<?php

namespace App\Http\Controllers;

use App\Models\CorreiosToken;
use App\Models\Range;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RangeController extends Controller
{
    // Listar as Etiquetas Disponíveis
    public function index(Request $request)
    {
        // Query base para etiquetas não utilizadas
        $query = Range::where('used', 0)->orderBy('id', 'ASC');

        // Adicionar filtro de pesquisa se existir
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('object_code', 'like', '%' . $searchTerm . '%');
        }

        $tracks = $query->paginate(55);

        // Salvar log
        Log::info('Listar as etiquetas não utilizadas.', [
            'action_user_id' => Auth::id()
        ]);

        // Carregar a view 
        return view('tracks.index', [
            'tracks' => $tracks,
            'search' => $request->search
        ]);
    }

    // Listar as Etiquetas Utilizadas
    public function show(Request $request)
    {
        // Query base para etiquetas utilizadas
        $query = Range::where('used', 1)->orderBy('id', 'DESC');

        // Adicionar filtro de pesquisa se existir
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('object_code', 'like', '%' . $searchTerm . '%');
        }

        $tracks = $query->paginate(55);

        // Salvar log
        Log::info('Listar as etiquetas utilizadas.', [
            'action_user_id' => Auth::id()
        ]);

        // Carregar a view 
        return view('tracks.show', [
            'tracks' => $tracks,
            'search' => $request->search
        ]);
    }

    // Carregar o formulário cadastrar nova Pré-Postagem
    public function create()
    {
        // Carregar a view 
        return view('tracks.create');
    }

    public function store(Request $request)
    {
        $correiosToken = CorreiosToken::latest()->first();

        if (!$correiosToken) {
            throw new Exception("Token dos Correios não encontrado.");
        }

        // Validação
        $request->validate([
            'amount' => 'required|integer|min:1'
        ]);

        // Corpo da requisição
        $payload = [
            "codigoServico" => "03220", // Número fixo
            "quantidade" => (int) $request->input('amount'),
        ];

        try {
            $response = Http::withoutVerifying()
                ->withToken($correiosToken->token)
                ->post('https://api.correios.com.br/prepostagem/v1/prepostagens/rotulo/range', $payload);

            if ($response->successful()) {
                $dados = $response->json()[0]; // pegar o primeiro elemento do array

                Log::info('Etiquetas geradas com sucesso', $dados);

                // Capturar informações do JSON
                $tipoPostal = $dados['tipoPostal']; // Exemplo: "AC"
                $nuEtiquetaInicial = intval($dados['nuEtiquetaInicial']); // Exemplo: 95024522
                $nuEtiquetaFinal = intval($dados['nuEtiquetaFinal']); // Exemplo: 95025021

                // Loop para salvar as etiquetas no banco, já calculando o dígito verificador
                for ($i = $nuEtiquetaInicial; $i <= $nuEtiquetaFinal; $i++) {
                    $sequencial = str_pad($i, 8, '0', STR_PAD_LEFT); // garante 8 dígitos com zeros à esquerda
                    $digitoVerificador = $this->calcularDigitoVerificador($sequencial);
                    $codigoEtiqueta = $tipoPostal . $sequencial . $digitoVerificador . 'BR';

                    // Salvar no banco
                    Range::create([
                        'object_code' => $codigoEtiqueta,
                        'used' => 0,
                    ]);
                }

                return back()->with('success', 'Etiquetas geradas e salvas com sucesso!');
            } else {
                Log::warning('Falha ao gerar etiquetas', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return back()->with('error', 'Erro ao gerar etiquetas, chame o suporte.');
            }
        } catch (\Exception $e) {
            Log::error('Erro ao enviar request para gerar etiquetas', [
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Erro interno ao tentar gerar etiquetas.');
        }
    }   

    // Função para calcular o dígito verificador conforme algoritmo fornecido
    private function calcularDigitoVerificador(string $numeroSequencial): int
    {
        $fatores = [8, 6, 4, 2, 3, 5, 9, 7];
        $soma = 0;

        for ($i = 0; $i < 8; $i++) {
            $soma += intval($numeroSequencial[$i]) * $fatores[$i];
        }

        $resto = $soma % 11;

        if ($resto === 0 || $resto === 1) {
            return $resto === 0 ? 5 : 0;
        }

        return 11 - $resto;
    }

    public function toggleInvoice(Request $request, $id)
{
    try {
        $range = Range::findOrFail($id);

        if ($range->selected == 0) {
            // Se não estiver selecionado, precisa de uma nota fiscal
            $request->validate([
                'invoice' => 'required|string|max:255'
            ]);

            $range->invoice = $request->invoice;
            $range->selected = 1;
        } else {
            // Se já está selecionado, desmarca e limpa a nota fiscal
            $range->invoice = null;
            $range->selected = 0;
        }

        $range->save();

        return response()->json([
            'success' => true,
            'message' => $range->selected 
                ? 'Nota fiscal vinculada com sucesso.' 
                : 'Nota fiscal removida com sucesso.',
            'data' => $range
        ]);
    } catch (\Exception $e) {
        Log::error('Erro ao alternar invoice: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Erro ao alternar invoice.'
        ], 500);
    }
}

public function findByInvoice($invoice)
{
    $range = Range::where('invoice', $invoice)->first();

    if (!$range) {
        return response()->json([
            'success' => false,
            'message' => 'Nenhum código de rastreamento encontrado para essa NF.'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'object_code' => $range->object_code
    ]);
}

}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sender;
use Illuminate\Http\Request;

class SenderApiController extends Controller
{
    public function buscar(Request $request)
    {
        $cnpj = $request->get('cnpj');
        $nome = $request->get('nome');

        $remetente = Sender::when($cnpj, function ($query, $cnpj) {
            return $query->where('cnpj', $cnpj);
        })
            ->when($nome, function ($query, $nome) {
                return $query->orWhere('name', 'like', "%{$nome}%");
            })
            ->first();

        if (! $remetente) {
            return response()->json(['message' => 'Remetente não encontrado'], 404);
        }

        return response()->json([
            'nome' => $remetente->name,
            'cnpj' => $remetente->cnpj,
            'cep' => $remetente->cep,
            'logradouro' => $remetente->public_place,
            'numero' => $remetente->number,
            'bairro' => $remetente->neighborhood,
            'cidade' => $remetente->city,
            'uf' => $remetente->uf,
        ]);
    }
}

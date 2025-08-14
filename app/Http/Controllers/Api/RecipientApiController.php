<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipient;

class RecipientApiController extends Controller
{
    public function buscar(Request $request)
    {
        $cnpj = $request->get('cnpj');
        $nome = $request->get('nome');

        $destinatario = Recipient::when($cnpj, function ($query, $cnpj) {
                return $query->where('cnpj', $cnpj);
            })
            ->when($nome, function ($query, $nome) {
                return $query->orWhere('name', 'like', "%{$nome}%");
            })
            ->first();

        if (!$destinatario) {
            return response()->json(['message' => 'Destinatário não encontrado'], 404);
        }

        return response()->json([
            'nome' => $destinatario->name,
            'cnpj' => $destinatario->cnpj,
            'cep' => $destinatario->cep,
            'logradouro' => $destinatario->public_place,
            'numero' => $destinatario->number,
            'bairro' => $destinatario->neighborhood,
            'cidade' => $destinatario->city,
            'uf' => $destinatario->uf,
        ]);
    }
}

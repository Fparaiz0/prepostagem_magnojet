<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipient;
use Illuminate\Http\Request;

class RecipientApiController extends Controller
{
  public function buscar(Request $request)
  {
    $cnpj = $request->get('cnpj');
    $nome = $request->get('nome');

    $query = Recipient::when($cnpj, function ($query, $cnpj) {
      return $query->where('cnpj', $cnpj);
    })
      ->when($nome, function ($query, $nome) {
        return $query->orWhere('name', 'like', "%{$nome}%");
      });

    $destinatarios = $query->get();

    if ($destinatarios->isEmpty()) {
      return response()->json(['message' => 'Destinatário não encontrado'], 404);
    }

    if ($destinatarios->count() === 1) {
      $destinatario = $destinatarios->first();

      return response()->json([
        'name' => $destinatario->name,
        'cnpj' => $destinatario->cnpj,
        'cep' => $destinatario->cep,
        'public_place' => $destinatario->public_place,
        'number' => $destinatario->number,
        'complement' => $destinatario->complement,
        'neighborhood' => $destinatario->neighborhood,
        'city' => $destinatario->city,
        'uf' => $destinatario->uf,
      ]);
    }

    return response()->json(
      $destinatarios->map(function ($d) {
        return [
          'id' => $d->id,
          'name' => $d->name,
          'cnpj' => $d->cnpj,
          'cep' => $d->cep,
          'public_place' => $d->public_place,
          'number' => $d->number,
          'complement' => $d->complement,
          'neighborhood' => $d->neighborhood,
          'city' => $d->city,
          'uf' => $d->uf,
        ];
      })
    );
  }
}

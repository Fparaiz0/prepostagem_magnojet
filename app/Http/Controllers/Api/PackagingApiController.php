<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Packaging;
use Illuminate\Http\Request;

class PackagingApiController extends Controller
{
    public function buscar(Request $request)
    {
        $nome = $request->get('nome');

        $embalagem = Packaging::when($nome, function ($query, $nome) {
            return $query->where('name', 'like', "%{$nome}%")
                ->where('active', 1);
        })
            ->first();

        if (! $embalagem) {
            return response()->json(['message' => 'Embalagem nao encontrada'], 404);
        }

        return response()->json([
            'nome' => $embalagem->name,
            'altura' => $embalagem->height,
            'largura' => $embalagem->width,
            'comprimento' => $embalagem->length,
            'diametro' => $embalagem->diameter,
            'peso' => $embalagem->weight,
        ]);
    }
}

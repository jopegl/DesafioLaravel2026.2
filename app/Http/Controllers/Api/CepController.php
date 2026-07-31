<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CepController extends Controller
{
    public function buscar(string $cep): JsonResponse
    {
        $cepLimpo = preg_replace('/[^0-9]/', '', $cep);

        if (strlen($cepLimpo) !== 8) {
            return response()->json(['erro' => 'CEP inválido'], 422);
        }

        $response = Http::get("https://viacep.com.br/ws/{$cepLimpo}/json/");

        if ($response->failed()) {
            return response()->json(['erro' => 'Não foi possível consultar o CEP'], 503);
        }

        $dados = $response->json();

        if (isset($dados['erro'])) {
            return response()->json(['erro' => 'CEP não encontrado'], 404);
        }

        return response()->json($dados);
    }
}

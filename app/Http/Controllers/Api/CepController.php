<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CepController extends Controller
{
    public function search(string $zipCode): JsonResponse
    {
        $cleanZipCode = preg_replace('/[^0-9]/', '', $zipCode);

        if (strlen($cleanZipCode) !== 8) {
            return response()->json(['error' => 'CEP inválido'], 422);
        }

        $response = Http::get("https://viacep.com.br/ws/{$cleanZipCode}/json/");

        if ($response->failed()) {
            return response()->json(['error' => 'Não foi possível consultar o CEP'], 503);
        }

        $data = $response->json();

        // 'erro' here is ViaCEP's own response field, not ours — keep as-is.
        if (isset($data['erro'])) {
            return response()->json(['error' => 'CEP não encontrado'], 404);
        }

        return response()->json($data);
    }
}

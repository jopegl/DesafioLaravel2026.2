<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class CepController extends Controller
{
    public function search(string $zipCode): JsonResponse
    {
        $cleanZipCode = preg_replace('/[^0-9]/', '', $zipCode);

        if (strlen($cleanZipCode) !== 8) {
            return response()->json(['error' => 'CEP inválido'], 422);
        }

        try {
            $response = Http::timeout(5)->get("https://viacep.com.br/ws/{$cleanZipCode}/json/");

            if ($response->failed()) {
                return response()->json(['error' => 'Não foi possível consultar o CEP'], 503);
            }

            $data = $response->json();

            if (isset($data['erro'])) {
                return response()->json(['error' => 'CEP não encontrado'], 404);
            }

            return response()->json($data);
        } catch (Throwable $e) {
            Log::error('Erro na requisição ao ViaCEP', [
                'cep' => $cleanZipCode,
                'message' => $e->getMessage(),
            ]);

            return response()->json(['error' => 'Serviço de CEP indisponível no momento'], 500);
        }
    }
}

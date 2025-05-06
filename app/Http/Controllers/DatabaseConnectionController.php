<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DatabaseConnectionController extends Controller
{
    public function checkConnection(): JsonResponse
    {
        try {
            DB::connection()->getPdo();
            return response()->json(['message' => '200 OK - Conectado ao banco de dados!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()], 500);
        }
    }
}

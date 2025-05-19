<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserSolicitanteRemessaService;
use Illuminate\Http\JsonResponse;

class UserSolicitanteRemessaController extends Controller
{
    protected $service;

    public function __construct(UserSolicitanteRemessaService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $data = $this->service->listAll();
        return response()->json($data);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'remessa_id' => 'required|exists:remessas,id',
            'user_id' => 'required|exists:users,id',
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
            'telefone' => 'required|string|max:20',
        ]);

        $registro = $this->service->create($validated);
        return response()->json($registro, 201);
    }
}

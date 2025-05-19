<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\RemessaPlanilhaService;

class RemessaPlanilhaController extends Controller
{
    protected $service;

    public function __construct(RemessaPlanilhaService $service)
    {
        $this->service = $service;
    }

    public function upload(Request $request, $remessaId): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'tipo' => 'nullable|string|max:100',
            'cliente_id' => 'required|exists:clients,id'
        ]);


        $planilha = $this->service->upload($request->file('file'), $remessaId, $request->cliente_id);

        return response()->json([
            'message' => 'Arquivo enviado com sucesso.',
            'data' => $planilha,
        ], 201);
    }

    public function listar($remessaId): JsonResponse
    {
        return response()->json($this->service->listByRemessa($remessaId));
    }
}

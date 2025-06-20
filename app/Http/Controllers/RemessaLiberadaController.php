<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RemessaLiberadaService;

class RemessaLiberadaController extends Controller
{
    protected $service;

    public function __construct(RemessaLiberadaService $service)
    {
        $this->service = $service;
    }

    public function liberarRemessa(Request $request)
    {
        $request->validate([
            'remessa_id' => 'required|exists:remessas,id',
            'tipo_entrega_id' => 'required|exists:tipos_entrega,id',
            'observacao' => 'required|string|min:10'
        ]);

        $liberacao = $this->service->liberarRemessa($request->all());

        return response()->json([
            'message' => 'Remessa liberada com sucesso.',
            'data' => $liberacao,
        ]);
    }

    public function remessasLiberadas()
    {
        return response()->json($this->service->listarLiberacoes());
    }

    public function show($remessaId)
    {
        return response()->json($this->service->buscarPorRemessa($remessaId));
    }
}

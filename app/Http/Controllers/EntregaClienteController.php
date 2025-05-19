<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EntregaClienteService;
use Illuminate\Support\Facades\Storage;

class EntregaClienteController extends Controller
{
    protected $service;

    public function __construct(EntregaClienteService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $request->validate([
            'remessa_id' => 'required|exists:remessas,id',
            'responsavel_recebimento' => 'required|string|max:255',
            'imagem_protocolo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['remessa_id', 'responsavel_recebimento']);

        if ($request->hasFile('imagem_protocolo')) {
            $path = $request->file('imagem_protocolo')->store('entregas/protocolos', 'public');
            $data['imagem_protocolo'] = $path;
        }

        $entrega = $this->service->registrarEntrega($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Entrega registrada com sucesso',
            'data' => $entrega,
        ], 201);
    }
}

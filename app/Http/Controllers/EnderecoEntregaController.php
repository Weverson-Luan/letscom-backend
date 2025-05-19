<?php

namespace App\Http\Controllers;

use App\Services\EnderecoEntregaService;
use Illuminate\Http\Request;

class EnderecoEntregaController extends Controller
{
    protected $service;

    public function __construct(EnderecoEntregaService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'logradouro' => 'nullable|string',
            'numero' => 'required|string',
            'complemento' => 'nullable|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string',
            'cep' => 'required|string',
            'nome_responsavel' => 'required|string',
            'email' => 'required|email',
            'setor' => 'required|string',
            'telefone' => 'required|string',
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->service->getById($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'logradouro' => 'nullable|string',
            'numero' => 'required|string',
            'complemento' => 'nullable|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string',
            'cep' => 'required|string',
            'nome_responsavel' => 'required|string',
            'email' => 'required|email',
            'setor' => 'required|string',
            'telefone' => 'required|string',
        ]);

        return response()->json($this->service->update($id, $data));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Endereço de entrega removido com sucesso.']);
    }
}

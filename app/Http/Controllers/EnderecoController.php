<?php

namespace App\Http\Controllers;

use App\Services\EnderecoService;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    protected $service;

    public function __construct(EnderecoService $service)
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
        'user_id' => 'required|integer|exists:users,id',
        'logradouro' => 'required|string',
        'numero' => 'required|string',
        'complemento' => 'nullable|string',
        'bairro' => 'required|string',
        'cidade' => 'required|string',
        'estado' => 'required|string',
        'cep' => 'required|string',
        'usar_mesmo_endereco_cadastrado_na_empresa' => 'boolean',
        'nome_responsavel' => 'required|string', // <- AQUI
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
            'logradouro' => 'required|string',
            'numero' => 'required|string',
            'complemento' => 'nullable|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string',
            'cep' => 'required|string',
            'usar_mesmo_endereco_cadastrado_na_empresa' => 'boolean',
        ]);

        return response()->json($this->service->update($id, $data));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Endereço removido com sucesso.']);
    }
}

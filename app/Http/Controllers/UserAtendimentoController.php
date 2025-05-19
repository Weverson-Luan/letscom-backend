<?php

namespace App\Http\Controllers;

use App\Services\UserAtendimentoService;
use Illuminate\Http\Request;

class UserAtendimentoController extends Controller
{
    protected $service;

    public function __construct(UserAtendimentoService $service)
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
            'nome' => 'nullable|string',
            'email' => 'required|email|unique:users_atendimentos,email',
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
            'nome' => 'nullable|string',
            'email' => 'sometimes|required|email|unique:users_atendimentos,email,' . $id,
            'telefone' => 'required|string',
        ]);

        return response()->json($this->service->update($id, $data));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Atendimento removido com sucesso.']);
    }
}

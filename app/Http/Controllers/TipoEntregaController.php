<?php

namespace App\Http\Controllers;

use App\Services\TipoEntregaService;
use Illuminate\Http\Request;

use App\Helpers\TiposEntregaResponseHelper;

class TipoEntregaController extends Controller
{
    protected $service;

    public function __construct(TipoEntregaService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $tiposEntrega = $this->service->getAll();


        return TiposEntregaResponseHelper::jsonSuccess(
            'Tipos de entrega carregados com sucesso!',
            TiposEntregaResponseHelper::mapTiposEntrega($tiposEntrega)
        );
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'cliente_id' => 'required|exists:users,id',
            'endereco_entrega_id' => 'nullable|exists:endereco_entrega,id',
            'tipo' => 'nullable|string',
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
            'endereco_entrega_id' => 'nullable|exists:endereco_entrega,id',
            'tipo' => 'nullable|string',
        ]);

        return response()->json($this->service->update($id, $data));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Tipo de entrega removido com sucesso.']);
    }
}

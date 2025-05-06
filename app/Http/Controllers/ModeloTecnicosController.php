<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ModeloTecnicoService;

class ModeloTecnicoController extends Controller
{
    protected $service;

    public function __construct(ModeloTecnicoService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->all());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->service->create($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->service->find($id));
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->service->update($id, $request->all()));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}

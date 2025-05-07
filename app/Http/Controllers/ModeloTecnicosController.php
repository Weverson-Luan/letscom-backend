<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ModeloTecnicosService;

class ModeloTecnicosController extends Controller
{
    protected $service;

    public function __construct(ModeloTecnicosService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {

        return response()->json($this->service->list($request->all()));
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

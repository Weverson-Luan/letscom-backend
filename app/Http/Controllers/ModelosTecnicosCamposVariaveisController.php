<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ModelosTecnicosCamposVariaveisService;

class ModelosTecnicosCamposVariaveisController extends Controller
{
    protected $service;

    public function __construct(ModelosTecnicosCamposVariaveisService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $params = $request->all();
        return response()->json($this->service->list($params));
    }

    public function show($id)
    {
        return response()->json($this->service->find($id));
    }
}

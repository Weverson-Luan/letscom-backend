<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\TecnologiasService;
use App\Helpers\TecnologiasResponseHelper;
use Illuminate\Support\Facades\Log;

class TecnologiasController extends Controller
{
    protected $service;

    public function __construct(TecnologiasService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
       try{

        // chamando o serviço
         $tecnologias = $this->service->list($request->all());

         // mandando os dados para uma função auxiliar
         $data = TecnologiasResponseHelper::mapTecnologias($tecnologias->items());

         // retornando os dados no padrão esperado
         return TecnologiasResponseHelper::jsonSuccess(
                'Tecnologias carregadas com sucesso!',
                $data,
                [
                    'current_page' => $tecnologias->currentPage(),
                    'last_page' => $tecnologias->lastPage(),
                    'per_page' => $tecnologias->perPage(),
                    'total' => $tecnologias->total(),
                ]
            );
       }catch(\Throwable $e){
        Log::error('Erro ao carregar tecnologias: ' . $e->getMessage());
        return TecnologiasResponseHelper::jsonError('Erro ao carregar tecnologias!');
       }
    }

    public function show($id)
    {
        return response()->json($this->service->getById($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|unique:tecnologias,nome|max:255',
            'descricao' => 'nullable|string|max:1000',
            'ativo' => 'required|boolean',
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255|unique:tecnologias,nome,' . $id,
            'descricao' => 'nullable|string|max:1000',
            'ativo' => 'required|boolean',
        ]);

        return response()->json($this->service->update($id, $data));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Tecnologia removida com sucesso']);
    }
}

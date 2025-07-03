<?php

namespace App\Http\Controllers;

use App\Services\EnderecoService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\EnderecoResponseHelper;


class EnderecoController extends Controller
{
    protected $service;

    public function __construct(EnderecoService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {

        $enderecos = $this->service->getAll($request->all());


        return EnderecoResponseHelper::jsonSuccess(
            'Lista paginada de endereços',
            EnderecoResponseHelper::mapEnderecos($enderecos['data']),
            [
                'current_page' => $enderecos['pagination']['current_page'],
                'last_page' => $enderecos['pagination']['last_page'],
                'per_page' => $enderecos['pagination']['per_page'],
                'total' => $enderecos['pagination']['total'],
            ]
        );
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
            'tipo_endereco' => 'required|string',
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

        $endereco = $this->service->getById($id);

        return EnderecoResponseHelper::jsonSingleEndereco(
            'Endereço carregado com sucesso!',
            $endereco ?? [],
        );
    }

    public function buscarEnderecosSeparados(Request $request, int $userId)
    {
        try {
            $enderecos = $this->service->buscarEnderecosSeparadosPorTipo($userId, $request->all());

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Endereços carregados com sucesso!',
                'data' => $enderecos
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao buscar endereços.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'logradouro' => 'nullable|string',
            'numero' => 'required|string',
            'complemento' => 'nullable|string',
            'bairro' => 'nullable|string',
            'cidade' => 'nullable|string',
            'estado' => 'nullable|string',
            'cep' => 'nullable|string',
            'nome_responsavel' => 'nullable|string',
            "telefone" => "nullable|string",
            "setor" => "nullable|string"
        ]);

        return response()->json($this->service->update($id, $data));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Endereço removido com sucesso.']);
    }
}

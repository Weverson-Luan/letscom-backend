<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserClienteService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use App\Helpers\UsuariosClientesResponseHelper;
class UserClienteController extends Controller
{
    protected $service;

    public function __construct(UserClienteService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->listAll());
    }

    public function show($id)
    {
        return response()->json($this->service->getById($id));
    }

    public function buscarUsuariosPorCliente(Request $request, int $id): JsonResponse
    {
        try {
            $params = $request->all();
            $params['user_id'] = $id;

            $response = $this->service->listUsarioPorCliente($params);


            // Extrai e mapeia os dados da paginação
            $usuarios = $response->items() ?? [];
            $pagination = [
                'current_page' => $response['current_page'] ?? 1,
                'last_page' => $response['last_page'] ?? 1,
                'per_page' => $response['per_page'] ?? 10,
                'total' => $response['total'] ?? count($usuarios),
            ];

            $usuariosMapeados = UsuariosClientesResponseHelper::mapModelo($usuarios);

            return UsuariosClientesResponseHelper::jsonSuccess(
                'Usuários do cliente carregados com sucesso!',
                $usuariosMapeados,
                $pagination
            );
        } catch (\Throwable $e) {
            \Log::error('Erro ao listar usuários do cliente:' . $e->getMessage());

            return UsuariosClientesResponseHelper::jsonError(
                 $e->getMessage(),
                500
            );
        }
    }

    public function store(Request $request)
    {

        $created = $this->service->create($request->all());

        return response()->json([
            'message' => 'Usuário do cliente criado com sucesso!',
            'data' => $created,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $resultData = $this->service->update($id, $data);

        return response()->json($resultData);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Usuário do cliente removido com sucesso']);
    }
}

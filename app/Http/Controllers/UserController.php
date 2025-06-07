<?php

namespace App\Http\Controllers;

use App\Helpers\UsersResponseHelper;

use App\Services\UserService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function buscarClientes(Request $request): JsonResponse
    {
        try {
            $result = $this->service->list($request->all());

            return UsersResponseHelper::jsonSuccess(
                'Usuários carregadas com sucesso!',
                $result['data'] ?? [],
                $result['pagination'] ?? null,

            );
        } catch (\Exception $e) {
            return UsersResponseHelper::jsonError($e->getMessage());
        }
    }

    public function buscarUsuariosConsultores(Request $request): JsonResponse
    {
        try {
            $result = $this->service->listUsuariosConsultores($request->all());

            return UsersResponseHelper::jsonSuccess(
                'Usuários consultores carregados com sucesso!',
                $result['data'] ?? [],
                $result['pagination'] ?? null,

            );
        } catch (\Exception $e) {
            return UsersResponseHelper::jsonError($e->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {

        // VALIDAÇÃO DOS CAMPOS VINDO BODY
        $validator = validator($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'documento' => 'required|string|unique:users,documento',
            'telefone' => 'required|string|unique:users,telefone',
            'tipo_pessoa' => 'required|in:F,J',
            'senha' => 'required|string|min:6',
            'roles' => 'nullable|integer|exists:roles,id',
            'consultor_id' => 'nullable|integer|exists:users,id',
            'tipo_entrega_id' => 'nullable|integer|exists:tipos_entrega,id',
        ], [
            'email.unique'=> "Este e-mail já está em uso por outro usuário!",
            'documento.unique' => 'Este documento já está em uso por outro usuário!',
            'telefone.unique' => 'Este telefone já está em uso por outro usuário!',
            'consultor_id' => "O id do consultor não foi encontrado!",
            'tipo_entrega_id' => "O id do tipo de entrega não foi encontrado!"
        ]);


        // VALIDANDO PARA VER SE NÃO HOUVE ERROR NA VALIDAÇÃO ANTERIOR
        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => 'Erro de validação dos dados informados!',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // CHAMANDO O SERVICO QUE FAZ A CRIAÇÃO
            $user = $this->service->create($request->all());

            // RESPONDENDO PARA O CLIENTE
            return response()->json([
                'message' => 'Usuário criado com sucesso!',
                'data' => $user
            ], 201);

        } catch (\Exception $e) {
            // RESPONDENDO PARA O CLIENTE COM ERROR 500
            return response()->json([
                'message' => 'Erro ao criar o usuário.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function buscarPorUmUsuario($id): JsonResponse
    {
        try {

            $user = $this->service->buscarUsuarioComTipoEntrega($id);

            return UsersResponseHelper::jsonSingleUser(
                    'Usuários encontrado com sucesso!',
                    $user ?? [],
            );
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return UsersResponseHelper::jsonErrorNotFoud('Usuário não encontrado.', 200);
            }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {

             $usuario = User::findOrFail($id);

             $data = $request->all();

             $success = $this->service->update($usuario, $data);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(User $user): JsonResponse
    {
        try {
            $success = $this->service->delete($user);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

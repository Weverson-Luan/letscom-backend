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

    public function store(Request $data): JsonResponse
    {
        try {
            // Validação manual
            $validator = validator($data->all(), [
                'nome' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'senha' => 'required|string|min:6',
                'roles' => 'nullable|integer|exists:roles,id',
            ], [
                'email.unique'=> "Este e-mail já está em uso por outro usuário!"
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erro de validação.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Verifica se o usuário já existe pelo e-mail
            $userAlreadExists = User::where('email', $data['email'])->first();

            if ($userAlreadExists) {
                return response()->json([
                    'message' => 'Já existe um usuário com este e-mail.'
                ], 409); // 409 Conflict
            }

            $user = User::create([
                'nome' => $data['nome'],
                'email' => $data['email'],
                'senha' => bcrypt($data['senha']),
                'documento' => $data['documento'],
                "ativo"=> $data['ativo'],
                'tipo_pessoa' => $data['tipo_pessoa'],
                "telefone"=> $data['telefone']
            ]);

            if (isset($data['roles'])) {
                // fazendo relacionamento de uma regra com usuário
                $user->roles()->sync([$data['roles']]);
            }

            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro inesperado.',
                'details' => $e->getMessage(),
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
        return UsersResponseHelper::jsonErrorNotFoud('Usuário não encontrado.', 404);
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

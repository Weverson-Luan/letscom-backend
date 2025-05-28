<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Lista usuários com paginação
     */
    public function list(array $params): array
    {
        try {

            $users = $this->repository->paginate($params);
            return [
                'data' => $users->items(),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total()
                ]
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao listar usuários: ' . $e->getMessage());
            throw $e;
        }
    }


    public function buscarUsuarioComTipoEntrega(int $id): ?User
    {
        return $this->repository->buscarUmUsuarioComRelacaoTipoEntrega($id);
    }

    /**
     * Cria um novo usuário
     */
    public function create(array $data): User
    {
        try {
            // // Hash da senha
            // if (isset($data['senha'])) {
            //     $data['senha'] = Hash::make($data['senha']);
            // }

            // // Extrai e remove roles do payload
            // $roles = $data['roles'] ?? null;
            // unset($data['roles']);

            // // Cria o usuário
            // $user = $this->repository->create($data);

            // // Associa roles se fornecidas
            // if ($roles) {
            //     // Aceita string ("admin") ou ID (1), ou array misto
            //     $roleIds = collect(is_array($roles) ? $roles : [$roles])
            //         ->map(function ($role) {
            //             if (is_numeric($role)) {
            //                 return (int) $role;
            //             }

            //             return Role::where('name', $role)->value('id');
            //         })
            //         ->filter(); // remove nulls

            //     $user->roles()->sync($roleIds);
            // }

            return ["ok"=> "kk"];

        } catch (\Exception $e) {
            Log::error('Erro ao criar usuário: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Atualiza um usuário existente
     */
    public function update(User $user, array $data): bool
    {
        try {

            if (isset($data['senha'])) {
                $data['senha'] = Hash::make($data['senha']);
            }
            return $this->repository->update($user, $data);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar usuário: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Remove um usuário
     */
    public function delete(User $user): bool
    {
        try {
            return $this->repository->delete($user);
        } catch (\Exception $e) {
            Log::error('Erro ao excluir usuário: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Busca usuário com suas permissões
     */
    public function findWithPermissions($id): ?User
    {
        return $this->repository->findWithPermissions($id);
    }


    public function generateCpfToken(string $cpf): string
    {
        $token = Str::random(32);
        Cache::put("cpf_token:{$token}", $cpf, now()->addMinutes(30));
        return $token;
    }

    public function getCpfFromToken(string $token): ?string
    {
        return Cache::get("cpf_token:{$token}");
    }

    public function refreshCpfToken(string $oldToken): string
    {
        $cpf = $this->getCpfFromToken($oldToken);
        if (!$cpf) {
            throw new \Exception('Token inválido ou expirado');
        }

        Cache::forget("cpf_token:{$oldToken}");
        $newToken = Str::random(32);
        Cache::put("cpf_token:{$newToken}", $cpf, now()->addMinutes(30));

        return $newToken;
    }

    public function authenticateUser(string $email, string $senha): ?User
    {
        $user = $this->repository->findByemail($email);

        if ($user) {
            $senhaCorreta = false;
            $senhaArmazenada = $user->senha;

            // Verifica se a senha está em formato Argon2
            if (str_starts_with($senhaArmazenada, '$argon2id$')) {
                $senhaCorreta = password_verify($senha, $senhaArmazenada);
            }
            // Verifica se a senha está em formato MD5
            elseif (strlen($senhaArmazenada) == 32 && ctype_xdigit($senhaArmazenada)) {
                $senhaCorreta = md5($senha) === $senhaArmazenada;
            }
            // Verifica se a senha está em texto simples
            else {
                $senhaCorreta = $senha === $senhaArmazenada;
            }

            if ($senhaCorreta) {
                return $user;
            }
        }

        return null;
    }

    /**
     * Verifica se o usuário tem permissão específica em um módulo
     *
     * @param string $cpf CPF do usuário
     * @param string $modulo Nome do módulo
     * @param string|array $permissoes Permissão ou array de permissões necessárias
     * @return bool
     */
    public function verificarPermissao(string $cpf, string $modulo, string|array $permissoes): bool
    {
        $user = $this->repository->findByCpf($cpf);

        if (!$user) {
            return false;
        }

        if (is_array($permissoes)) {
            return $user->hasAllPermissions($modulo, $permissoes);
        }

        return $user->hasPermission($modulo, $permissoes);
    }
}

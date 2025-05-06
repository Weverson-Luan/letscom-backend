<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\UserService;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\JWTService;

class AuthController extends Controller
{
    protected $userService;
    protected $jwtService;

    /**
     * Construtor do AuthController.
     *
     * @param UserService $userService O serviço de usuário a ser injetado.
     * @param JWTService $jwtService O serviço de gerenciamento de tokens JWT a ser injetado.
     */
    public function __construct(UserService $userService, JWTService $jwtService)
    {
        $this->userService = $userService;
        $this->jwtService = $jwtService;
    }


    private function identificarPerfil(array $permissions): string
    {
        if (isset($permissions['users']) && $permissions['users'] === 'CRUD') {
            return 'admin';
        }

        if (isset($permissions['clients']) && $permissions['clients'] === 'CRUD') {
            return 'gerente';
        }

        if (isset($permissions['clients']) && $permissions['clients'] === 'R') {
            return 'vendedor';
        }

        return 'cliente'; // padrão
    }

    /**
     * Realiza o login do usuário.
     * Este método verifica as credenciais do usuário e gera um token JWT se as credenciais forem válidas.
     * Ele lida com senhas armazenadas em diferentes formatos: Argon2, MD5 e texto simples.
     * O token JWT gerado é armazenado em cache por 30 minutos.
     *
     * @param Request $request A requisição HTTP contendo as credenciais do usuário.
     * @return \Illuminate\Http\JsonResponse A resposta JSON contendo o token de autenticação ou uma mensagem de erro.
     *
     * @throws \Illuminate\Validation\ValidationException Se as credenciais fornecidas não passarem na validação.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'senha');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['senha'], $user->senha)) {
            return response()->json([
                "code" => 401,
                "status"=> "error",
                'error' => 'Usuário ou senha inválidos. Verifique suas credenciais e tente novamente!',

            ], 401);
        }

        // Adicionando log para debug
        Log::info('Usuário encontrado no login:', [
            'cpf' => $user->cpf,
            'email' => $user->email
        ]);

        $token = $this->jwtService->createToken([
            'sub' => $user->cpf,
            'email' => $user->email
        ]);

        $perfil = $this->identificarPerfil($user->permissoes);

        return response()->json([
            "code" => 200,
            "message" => "Usuário logado com sucesso!",
            "data" => $user,
            "token" => $token,
            "role" => $perfil
        ]);
    }

    private function verificarSenha($senhaFornecida, $senhaArmazenada)
    {
        if (str_starts_with($senhaArmazenada, '$argon2id$')) {
            return password_verify($senhaFornecida, $senhaArmazenada);
        } elseif (strlen($senhaArmazenada) == 32 && ctype_xdigit($senhaArmazenada)) {
            return md5($senhaFornecida) === $senhaArmazenada;
        }
        return $senhaFornecida === $senhaArmazenada;
    }

    private function gerarToken($user)
    {
        return JWT::encode([
            'sub' => $user->CPF,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + 60 * 60
        ], config('app.jwt_secret'), 'HS256');
    }

    private function armazenarTokenNoCache($user, $token)
    {
        $cacheKey = 'jwt_token_' . $user->CPF;
        $cacheData = [
            'token' => $token,
            'email' => $user->email
        ];

        if (!Cache::put($cacheKey, $cacheData, now()->addMinutes(30))) {
            throw new \Exception('Falha ao armazenar token no cache');
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;



use Illuminate\Http\Request;
use App\Services\UserService;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserCliente;

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
        // if (isset($permissions['users']) && $permissions['users'] === 'CRUD') {
        //     return 'admin';
        // }

        // if (isset($permissions['clients']) && $permissions['clients'] === 'CRUD') {
        //     return 'gerente';
        // }

        // if (isset($permissions['clients']) && $permissions['clients'] === 'R') {
        //     return 'vendedor';
        // }

        return 'cliente'; // padrão
    }

    public function roles()
{
    return $this->belongsToMany(Role::class);
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
    $credentialsBody = $request->only('email', 'senha');

    // TENTATIVA 1: login como User (empresa/admin)
    $user = User::with('roles')->where('email', $credentialsBody['email'])->first();

    if ($user && Hash::check($credentialsBody['senha'], $user->senha)) {
        $token = $this->jwtService->createToken([
            'sub' => $user->id,
            'email' => $user->email,
        ]);

        $role = optional($user->roles->first())->makeHidden('pivot');

        return response()->json([
            "code" => 200,
            "message" => "Usuário logado com sucesso!",
            "data" => [
                "id" => $user->id,
                "tipo_login" => "user",
                "nome" => $user->nome,
                "email" => $user->email,
                "cpf" => $user->cpf ?? null,
                "cnpj" => $user->cnpj ?? null,
                "tipo_pessoa" => $user->tipo_pessoa,
                "roles" => $role,
            ],
            "token" => $token,
        ]);
    }

    // TENTATIVA 2: login como UserCliente (representante)
    $clienteUser = UserCliente::where('email', $credentialsBody['email'])->first();

    if ($clienteUser && Hash::check($credentialsBody['senha'], $clienteUser->senha)) {
        $token = $this->jwtService->createToken([
            'sub' => $clienteUser->id,
            'email' => $clienteUser->email,
            'cliente_id' => $clienteUser->cliente_id,
        ]);

        return response()->json([
            "code" => 200,
            "message" => "Usuário cliente logado com sucesso!",
            "data" => [
                "id" => $clienteUser->id,
                "tipo_login" => "cliente_usuario",
                "nome" => $clienteUser->nome,
                "email" => $clienteUser->email,
                "cliente_id" => $clienteUser->cliente_id,
                "roles" => [
                    "id" => 100,
                    "nome" => "Subordinado",
                    "descricao" => "Usuário vinculado a uma empresa cliente, com acesso limitado para realizar ações em nome da organização. Pode visualizar e solicitar remessas, consultar entregas, e interagir com funcionalidades autorizadas pela empresa principal."

                ]
            ],
            "token" => $token,
        ]);
    }

    // Nenhum dos dois logins funcionou
    return response()->json([
        "code" => 401,
        "status"=> "error",
        'error' => 'Usuário ou senha inválidos. Verifique suas credenciais e tente novamente!',
    ], 401);
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
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + 60 * 60
        ], config('app.jwt_secret'), 'HS256');
    }

    private function armazenarTokenNoCache($user, $token)
    {
        $cacheKey = 'jwt_token_' . $user->id;

        // Remove token anterior, se existir
        Cache::forget($cacheKey);

        $cacheData = [
            'token' => $token,
            'email' => $user->email
        ];

        // Armazena indefinidamente
        if (!Cache::forever($cacheKey, $cacheData)) {
            throw new \Exception('Falha ao armazenar token no cache');
        }
    }
}

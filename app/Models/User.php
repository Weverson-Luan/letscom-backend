<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'email',
        'senha',
        "ativo",
        'documento',
        'tipo_pessoa',
        "telefone"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissoes' => 'array',
    ];

    /**
     * Verifica se o usuário tem permissão específica para um módulo
     *
     * @param string $modulo Nome do módulo (ex: 'clients', 'products')
     * @param string $permissao Tipo de permissão (read, create, update, delete)
     * @return bool
     */
    public function hasPermission(string $modulo, string $permissao): bool
    {
        Log::info('Verificando permissão:', [
            'modulo' => $modulo,
            'permissao' => $permissao,
            'permissoes_usuario' => $this->permissoes
        ]);

        if (!$this->permissoes || !isset($this->permissoes[$modulo])) {
            Log::warning('Módulo não encontrado nas permissões');
            return false;
        }

        // Mapeia as permissões de texto para CRUD
        $permissionMap = [
            'create' => 'C',
            'read' => 'R',
            'update' => 'U',
            'delete' => 'D'
        ];

        // Converte a permissão para o formato CRUD
        $permissaoCRUD = $permissionMap[$permissao] ?? $permissao;

        $temPermissao = str_contains($this->permissoes[$modulo], $permissaoCRUD);

        Log::info('Resultado da verificação:', [
            'tem_permissao' => $temPermissao,
            'permissao_procurada' => $permissaoCRUD,
            'permissoes_do_modulo' => $this->permissoes[$modulo]
        ]);

        return $temPermissao;
    }

    /**
     * Verifica se o usuário tem todas as permissões especificadas para um módulo
     *
     * @param string $modulo Nome do módulo
     * @param array $permissoes Array de permissões necessárias
     * @return bool
     */
    public function hasAllPermissions(string $modulo, array $permissoes): bool
    {
        foreach ($permissoes as $permissao) {
            if (!$this->hasPermission($modulo, $permissao)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Define as permissões para um módulo específico
     *
     * @param string $modulo Nome do módulo
     * @param array $permissoes Array de permissões (ex: ['C', 'R', 'U', 'D'])
     * @return void
     */
    public function setModulePermissions(string $modulo, array $permissoes): void
    {
        $permissoesAtuais = $this->permissoes ?? [];
        $permissoesAtuais[$modulo] = implode('', array_unique($permissoes));
        $this->permissoes = $permissoesAtuais;
    }

    public function setCpfAttribute($value): void
    {
        $this->attributes['CPF'] = $value;
    }


    public function getAuthIdentifierName(): string
    {
        return 'CPF';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function produtosVinculados(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'produtos_vinculados_usuarios', 'user_id', 'produto_id')
                    ->withTimestamps();
    }
}

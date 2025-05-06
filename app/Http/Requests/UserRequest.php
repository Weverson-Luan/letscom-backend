<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request para validação de Usuários
 * 
 * @package App\Http\Requests
 * @version 1.0.0
 */
class UserRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Regras de validação
     */
    public function rules(): array
    {
        $rules = [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'senha' => 'required|string|min:6',
            'permissions' => 'sometimes|array',
            'permissions.*.module' => 'required_with:permissions|string',
            'permissions.*.permissions' => 'required_with:permissions|string|in:C,R,U,D'
        ];

        if ($this->isMethod('PUT')) {
            $id = $this->route('user');
            $rules['email'] = "sometimes|email|unique:users,email,{$id}";
            $rules['senha'] = 'sometimes|string|min:6';
        }

        return $rules;
    }

    /**
     * Mensagens de erro personalizadas
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'E-mail inválido',
            'email.unique' => 'Este e-mail já está em uso',
            'senha.required' => 'A senha é obrigatória',
            'senha.min' => 'A senha deve ter no mínimo 6 caracteres',
            'permissions.array' => 'As permissões devem ser um array',
            'permissions.*.module.required_with' => 'O módulo é obrigatório para cada permissão',
            'permissions.*.permissions.required_with' => 'As permissões são obrigatórias para cada módulo',
            'permissions.*.permissions.in' => 'Permissões inválidas. Use: C, R, U, D'
        ];
    }
} 
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request para validação de Clientes
 * 
 * @package App\Http\Requests
 * @version 1.0.0
 */
class ClientRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição
     * 
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Regras de validação
     * 
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'telefone' => 'required|string|max:20',
            'cpf_cnpj' => 'required|string|unique:clients,cpf_cnpj',
            'tipo_pessoa' => 'required|in:PF,PJ',
            'endereco' => 'required|string|max:255',
            'cep' => 'required|string|max:9',
            'bairro' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'numero' => 'required|string|max:20',
            'complemento' => 'nullable|string|max:100'
        ];

        if ($this->isMethod('PUT')) {
            $id = $this->route('client');
            $rules['email'] = "sometimes|email|unique:clients,email,{$id}";
            $rules['cpf_cnpj'] = "sometimes|string|unique:clients,cpf_cnpj,{$id}";
            
            $rules = array_map(function ($rule) {
                return str_replace('required|', '', $rule);
            }, $rules);
        }

        return $rules;
    }

    /**
     * Mensagens de erro personalizadas
     * 
     * @return array
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'E-mail inválido',
            'email.unique' => 'Este e-mail já está em uso',
            'telefone.required' => 'O telefone é obrigatório',
            'cpf_cnpj.required' => 'O CPF/CNPJ é obrigatório',
            'cpf_cnpj.unique' => 'Este CPF/CNPJ já está em uso',
            'tipo_pessoa.required' => 'O tipo de pessoa é obrigatório',
            'tipo_pessoa.in' => 'Tipo de pessoa inválido',
            'endereco.required' => 'O endereço é obrigatório',
            'cep.required' => 'O CEP é obrigatório',
            'bairro.required' => 'O bairro é obrigatório',
            'cidade.required' => 'A cidade é obrigatória',
            'estado.required' => 'O estado é obrigatório',
            'estado.size' => 'O estado deve ter 2 caracteres',
            'numero.required' => 'O número é obrigatório'
        ];
    }
} 
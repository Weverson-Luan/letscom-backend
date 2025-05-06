<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request para validação de Vendas de Créditos
 * 
 * @package App\Http\Requests
 * @version 1.0.0
 */
class CreditSaleRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'valor' => 'required|numeric|min:0',
            'quantidade_creditos' => 'required|numeric|min:0',
        ];

        if ($this->isMethod('PUT')) {
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
            'client_id.required' => 'O cliente é obrigatório',
            'client_id.exists' => 'Cliente não encontrado',
            'valor.required' => 'O valor é obrigatório',
            'valor.numeric' => 'O valor deve ser um número',
            'quantidade_creditos.required' => 'A quantidade de créditos é obrigatória',
            'quantidade_creditos.numeric' => 'A quantidade de créditos deve ser um número'
        ];
    }
} 
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request para validação de Remessas
 * 
 * @package App\Http\Requests
 * @version 1.0.0
 */
class RemessaRequest extends FormRequest
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
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantidade' => 'required|integer|min:1',
            'status' => 'sometimes|in:pendente,confirmado,cancelado'
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
            'items.required' => 'Os itens são obrigatórios',
            'items.array' => 'Os itens devem ser um array',
            'items.min' => 'A remessa deve ter pelo menos um item',
            'items.*.product_id.required' => 'O produto é obrigatório',
            'items.*.product_id.exists' => 'Produto não encontrado',
            'items.*.quantidade.required' => 'A quantidade é obrigatória',
            'items.*.quantidade.integer' => 'A quantidade deve ser um número inteiro',
            'items.*.quantidade.min' => 'A quantidade deve ser maior que zero',
            'status.in' => 'Status inválido'
        ];
    }
} 
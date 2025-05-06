<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request para validação de Produtos
 * 
 * @package App\Http\Requests
 * @version 1.0.0
 */
class ProductRequest extends FormRequest
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
            'tecnologia' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'valor_creditos' => 'required|numeric|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'estoque_maximo' => 'required|integer|min:0|gt:estoque_minimo',
            'estoque_atual' => 'required|integer|min:0|between:estoque_minimo,estoque_maximo'
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
            'nome.required' => 'O nome do produto é obrigatório',
            'tecnologia.required' => 'A tecnologia é obrigatória',
            'valor.required' => 'O valor é obrigatório',
            'valor.numeric' => 'O valor deve ser um número',
            'valor_creditos.required' => 'O valor em créditos é obrigatório',
            'valor_creditos.numeric' => 'O valor em créditos deve ser um número',
            'estoque_minimo.required' => 'O estoque mínimo é obrigatório',
            'estoque_maximo.required' => 'O estoque máximo é obrigatório',
            'estoque_maximo.gt' => 'O estoque máximo deve ser maior que o mínimo',
            'estoque_atual.between' => 'O estoque atual deve estar entre o mínimo e máximo'
        ];
    }
} 
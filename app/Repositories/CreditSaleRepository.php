<?php

namespace App\Repositories;

use App\Models\CreditSale;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Repositório para gerenciamento de Vendas de Créditos
 * 
 * @package App\Repositories
 * @version 1.0.0
 */
class CreditSaleRepository
{
    /** @var CreditSale */
    protected $model;

    /**
     * Construtor do repositório
     * 
     * @param CreditSale $model Modelo de Venda de Créditos
     */
    public function __construct(CreditSale $model)
    {
        $this->model = $model;
    }

    /**
     * Lista vendas com paginação e filtros
     * 
     * @param array $params Parâmetros de filtro e paginação
     * @return LengthAwarePaginator
     */
    public function paginate(array $params): LengthAwarePaginator
    {
        return $this->model->with('client')
            ->when($params['search'] ?? null, function($q) use ($params) {
                $q->whereHas('client', function($query) use ($params) {
                    $query->where('nome', 'like', "%{$params['search']}%");
                });
            })
            ->orderBy($params['sort_by'] ?? 'created_at', $params['order'] ?? 'desc')
            ->paginate($params['per_page'] ?? 10);
    }

    /**
     * Cria uma nova venda de créditos
     * 
     * @param array $data Dados da venda
     * @return CreditSale
     */
    public function create(array $data): CreditSale
    {
        return $this->model->create($data);
    }

    /**
     * Busca uma venda pelo ID
     * 
     * @param int $id ID da venda
     * @return CreditSale|null
     */
    public function find($id): ?CreditSale
    {
        return $this->model->with('client')->find($id);
    }

    /**
     * Atualiza uma venda
     * 
     * @param CreditSale $creditSale Venda a ser atualizada
     * @param array $data Novos dados
     * @return bool
     */
    public function update(CreditSale $creditSale, array $data): bool
    {
        return $creditSale->update($data);
    }

    /**
     * Remove uma venda
     * 
     * @param CreditSale $creditSale Venda a ser removida
     * @return bool
     */
    public function delete(CreditSale $creditSale): bool
    {
        return $creditSale->delete();
    }
} 
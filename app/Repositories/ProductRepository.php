<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Repositório para gerenciamento de Produtos
 * 
 * @package App\Repositories
 * @version 1.0.0
 */
class ProductRepository
{
    /** @var Product */
    protected $model;

    /**
     * Construtor do repositório
     * 
     * @param Product $model Modelo de Produto
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    /**
     * Lista produtos com paginação e filtros
     * 
     * @param array $params Parâmetros de filtro e paginação
     * @return LengthAwarePaginator
     */
    public function paginate(array $params): LengthAwarePaginator
    {
        $query = $this->model->query();
        
        if (!empty($params['search'])) {
            $query->where(function($q) use ($params) {
                $q->where('nome', 'like', "%{$params['search']}%")
                  ->orWhere('tecnologia', 'like', "%{$params['search']}%");
            });
        }
        
        return $query->orderBy(
            $params['sort_by'] ?? 'created_at',
            $params['order'] ?? 'desc'
        )->paginate($params['per_page'] ?? 10);
    }

    /**
     * Cria um novo produto
     * 
     * @param array $data Dados do produto
     * @return Product
     */
    public function create(array $data): Product
    {
        return $this->model->create($data);
    }

    /**
     * Busca um produto pelo ID
     * 
     * @param int $id ID do produto
     * @return Product|null
     */
    public function find($id): ?Product
    {
        return $this->model->find($id);
    }

    /**
     * Atualiza um produto
     * 
     * @param Product $product Produto a ser atualizado
     * @param array $data Novos dados
     * @return bool
     */
    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }

    /**
     * Remove um produto
     * 
     * @param Product $product Produto a ser removido
     * @return bool
     */
    public function delete(Product $product): bool
    {
        return $product->delete();
    }
} 
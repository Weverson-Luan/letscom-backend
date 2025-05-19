<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Serviço para gerenciamento de Produtos
 *
 * @package App\Services
 * @version 1.0.0
 */
class ProductService
{
    /** @var ProductRepository */
    protected $repository;

    /**
     * Construtor do serviço
     *
     * @param ProductRepository $repository Repositório de produtos
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Lista produtos com paginação
     *
     * @param array $params Parâmetros de filtro e paginação
     * @return array
     * @throws \Exception
     */
    public function list(array $params): LengthAwarePaginator
    {
        try {
            $products = $this->repository->paginate($params);

            return $products;
        } catch (\Exception $e) {
            Log::error('Erro ao listar produtos: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Cria um novo produto
     *
     * @param array $data Dados do produto
     * @return Product
     * @throws \Exception
     */
    public function create(array $data): Product
    {
        try {
            DB::beginTransaction();
            $product = $this->repository->create($data);
            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar produto: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Atualiza um produto existente
     *
     * @param Product $product Produto a ser atualizado
     * @param array $data Novos dados
     * @return bool
     * @throws \Exception
     */
    public function update(Product $product, array $data): bool
    {
        try {
            DB::beginTransaction();
            $success = $this->repository->update($product, $data);
            DB::commit();

            return $success;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar produto: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Remove um produto
     *
     * @param Product $product Produto a ser removido
     * @return bool
     * @throws \Exception
     */
    public function delete(Product $product): bool
    {
        try {
            DB::beginTransaction();
            $success = $this->repository->delete($product);
            DB::commit();

            return $success;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir produto: ' . $e->getMessage());
            throw $e;
        }
    }
}

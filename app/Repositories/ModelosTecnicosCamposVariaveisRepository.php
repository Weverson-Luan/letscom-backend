<?php

namespace App\Repositories;

use App\Models\ModelosTecnicosCamposVariaveis;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Repositório para gerenciamento de modelo de cliente
 *
 * @package App\Repositories
 * @version 1.0.0
 */
class ModelosTecnicosCamposVariaveisRepository
{
    /** @var ModelosTecnicosCamposVariaveis */
    protected $model;

    /**
     * Construtor do repositório
     *
     * @param ModelosTecnicosCamposVariaveis $model Modelo de modelo tecnico
     */
    public function __construct(ModelosTecnicosCamposVariaveis $model)
    {
        $this->model = $model;
    }

    /**
     * Lista modelos com paginação e filtros
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
                  ->orWhere('nome_modelo', 'like', "%{$params['search']}%");
            });
        }

        return $query->orderBy(
            $params['sort_by'] ?? 'created_at',
            $params['order'] ?? 'desc'
        )->paginate($params['per_page'] ?? 10);

    }

    /**
     * Cria um novo modelo para cliente
     *
     * @param array $data Dados do modelo
     * @return ModelosTecnicosCamposVariaveis
     */
    public function create(array $data): Product
    {
        return $this->model->create($data);
    }

    /**
     * Busca um modelo pelo ID
     *
     * @param int $id ID do modelo para cliente
     * @return ModelosTecnicosCamposVariaveis|null
     */
    public function find($id): ?ModelosTecnicosCamposVariaveis
    {
        return $this->model->find($id);
    }

    /**
     * Atualiza um modelo de cliente
     *
     * @param ModelosTecnicosCamposVariaveis $modelo Modelo a ser atualizado
     * @param array $data Novos dados
     * @return bool
     */
    public function update(ModeloTecnico $modelo, array $data): bool
    {
        return $modelo->update($data);
    }

    /**
     * Remove um produto
     *
     * @param ModelosTecnicosCamposVariaveis $product Modelo a ser removido
     * @return bool
     */
    public function delete(ModelosTecnicosCamposVariaveis $modelo): bool
    {
        return $product->delete();
    }
}

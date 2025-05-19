<?php

namespace App\Repositories;

use App\Models\ModelosTecnicosCamposVariaveis;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Repositório para gerenciamento de campos variáveis de modelos técnicos.
 *
 * @package App\Repositories
 * @version 1.0.0
 */
class ModelosTecnicosCamposVariaveisRepository
{
    protected ModelosTecnicosCamposVariaveis $model;

    public function __construct(ModelosTecnicosCamposVariaveis $model)
    {
        $this->model = $model;
    }

    /**
     * Lista os campos com paginação e filtros.
     */
    public function paginate(array $params): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($params['search'])) {
            $query->where('nome', 'like', "%{$params['search']}%");
        }

        return $query->orderBy(
            $params['sort_by'] ?? 'created_at',
            $params['order'] ?? 'desc'
        )->paginate($params['per_page'] ?? 10);
    }

    /**
     * Cria um novo campo variável.
     */
    public function create(array $data): ModelosTecnicosCamposVariaveis
    {
        return $this->model->create($data);
    }

    /**
     * Busca um campo variável pelo ID.
     */
    public function find(int $id): ?ModelosTecnicosCamposVariaveis
    {
        return $this->model->find($id);
    }

    /**
     * Atualiza um campo existente.
     */
    public function update(ModelosTecnicosCamposVariaveis $modelo, array $data): bool
    {
        return $modelo->update($data);
    }

    /**
     * Remove um campo variável.
     */
    public function delete(ModelosTecnicosCamposVariaveis $modelo): bool
    {
        return $modelo->delete();
    }
}

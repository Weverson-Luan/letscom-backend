<?php

namespace App\Repositories;

use App\Models\Remessa;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Repositório para gerenciamento de Remessas
 *
 * @package App\Repositories
 * @version 1.0.0
 */
class RemessaRepository
{
    /** @var Remessa */
    protected $model;

    /**
     * Construtor do repositório
     *
     * @param Remessa $model Modelo de Remessa
     */
    public function __construct(Remessa $model)
    {
        $this->model = $model;
    }

    /**
     * Lista remessas com paginação e filtros
     *
     * @param array $params Parâmetros de filtro e paginação
     * @return LengthAwarePaginator
     */
    public function paginate(array $params): LengthAwarePaginator
    {
        return $this->model->with(['client', 'items.product'])
            ->when($params['search'] ?? null, function($q) use ($params) {
                $q->whereHas('client', function($query) use ($params) {
                    $query->where('nome', 'like', "%{$params['search']}%");
                });
            })
            ->orderBy($params['sort_by'] ?? 'created_at', $params['order'] ?? 'desc')
            ->paginate($params['per_page'] ?? 10);
    }

    /**
     * Cria uma nova remessa
     *
     * @param array $data Dados da remessa
     * @return Remessa
     */
    public function create(array $data): Remessa
    {
        return $this->model->create($data);
    }

    /**
     * Busca uma remessa pelo ID
     *
     * @param int $id ID da remessa
     * @return Remessa|null
     */
    public function find($id): ?Remessa
    {
        return $this->model->with(['client', 'items.product'])->find($id);
    }

    /**
     * Atualiza uma remessa
     *
     * @param Remessa $remessa Remessa a ser atualizada
     * @param array $data Novos dados
     * @return bool
     */
    public function update(Remessa $remessa, array $data): bool
    {
        return $remessa->update($data);
    }

    /**
     * Remove uma remessa
     *
     * @param Remessa $remessa Remessa a ser removida
     * @return bool
     */
    public function delete(Remessa $remessa): bool
    {
        return $remessa->delete();
    }
}

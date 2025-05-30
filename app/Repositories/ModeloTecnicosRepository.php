<?php

namespace App\Repositories;

use App\Models\ModeloTecnico;
use Illuminate\Pagination\LengthAwarePaginator;


class ModeloTecnicosRepository
{
    protected ModeloTecnico $model;

    public function __construct(ModeloTecnico $model)
    {
        $this->model = $model;
    }

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

    public function buscarPorCliente(array $params): LengthAwarePaginator
    {
        // $query = $this->model->query();
           $query = $this->model->with([
            'cliente:id,nome,email', // carrega apenas os campos necessários
            'produto',
            'tecnologia',
            'camposVariaveis',
            ]);

        if (!empty($params['cliente_id'])) {
            $query->where('cliente_id', $params['cliente_id']);
        }

        if (!empty($params['search'])) {
            $query->where(function ($q) use ($params) {
                $q->where('nome', 'like', "%{$params['search']}%")
                ->orWhere('nome_modelo', 'like', "%{$params['search']}%");
            });
        }

        return $query->orderBy(
            $params['sort_by'] ?? 'created_at',
            $params['order'] ?? 'desc'
        )->paginate($params['per_page'] ?? 10);
    }


    public function create(array $data): ModeloTecnico
    {
        return $this->model->create($data);
    }

    public function find($id): ?ModeloTecnico
    {
        return $this->model->find($id);
    }

    public function update($id, array $data)
    {
       $modelo = $this->find(2);
       $modelo->update($data);
        return $modelo;
    }

    public function delete(ModeloTecnico $modelo): bool
    {
        return $modelo->delete();
    }
}

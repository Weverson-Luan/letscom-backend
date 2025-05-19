<?php

namespace App\Repositories;

use App\Models\Tecnologias;
use Illuminate\Pagination\LengthAwarePaginator;


class TecnologiasRepository
{
    protected Tecnologias $modelTecnologiaRepository;

    public function __construct(Tecnologias $modelTecnologiaRepository)
    {
        $this->modelTecnologiaRepository = $modelTecnologiaRepository;
    }


    public function paginate(array $params): LengthAwarePaginator
    {
        $query = $this->modelTecnologiaRepository->query();

        return $query
            ->when(!empty($params['search']), function ($q) use ($params) {
                $q->where('nome', 'like', '%' . $params['search'] . '%');
            })
            ->orderBy($params['sort_by'] ?? 'created_at', $params['order'] ?? 'desc')
            ->paginate($params['per_page'] ?? 10);
    }

    public function find($id)
    {
        return Tecnologias::findOrFail($id);
    }

    public function create(array $data)
    {
        return Tecnologias::create($data);
    }

    public function update($id, array $data)
    {
        $tecnologia = Tecnologias::findOrFail($id);
        $tecnologia->update($data);
        return $tecnologia;
    }

    public function delete($id)
    {
        return Tecnologias::destroy($id);
    }
}

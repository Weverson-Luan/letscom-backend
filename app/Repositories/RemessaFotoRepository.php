<?php
namespace App\Repositories;

use App\Models\RemessaFoto;

class RemessaFotoRepository
{
    protected $model;

    public function __construct(RemessaFoto $model)
    {
        $this->model = $model;
    }

    public function create(array $data): RemessaFoto
    {
        return $this->model->create($data);
    }

    public function findByRemessaId(int $remessaId)
    {
        return $this->model->where('remessa_id', $remessaId)->get();
    }

    public function deleteByRemessaId(int $remessaId): int
    {
        return $this->model->where('remessa_id', $remessaId)->delete();
    }
}

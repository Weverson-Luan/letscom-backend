<?php
namespace App\Services;

use App\Models\ModeloTecnico;

class ModeloTecnicoService
{
    public function create(array $data): ModeloTecnico
    {
        return ModeloTecnico::create($data);
    }

    public function all()
    {
        return ModeloTecnico::all();
    }

    public function find($id)
    {
        return ModeloTecnico::findOrFail($id);
    }

    public function update($id, array $data): ModeloTecnico
    {
        $modelo = ModeloTecnico::findOrFail($id);
        $modelo->update($data);
        return $modelo;
    }

    public function delete($id): bool
    {
        return ModeloTecnico::destroy($id);
    }
}

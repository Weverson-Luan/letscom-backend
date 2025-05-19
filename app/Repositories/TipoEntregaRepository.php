<?php

namespace App\Repositories;

use App\Models\TipoEntrega;

class TipoEntregaRepository
{
    public function all()
    {
        return TipoEntrega::with(['criador', 'cliente', 'enderecoEntrega'])->get();
    }

    public function find($id)
    {
        return TipoEntrega::with(['criador', 'cliente', 'enderecoEntrega'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return TipoEntrega::create($data);
    }

    public function update($id, array $data)
    {
        $entrega = $this->find($id);
        $entrega->update($data);
        return $entrega;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}

<?php

namespace App\Repositories;

use App\Models\EnderecoEntrega;

class EnderecoEntregaRepository
{
    public function all()
    {
        return EnderecoEntrega::with('user')->get();
    }

    public function find($id)
    {
        return EnderecoEntrega::with('user')->findOrFail($id);
    }

    public function create(array $data)
    {
        return EnderecoEntrega::create($data);
    }

    public function update($id, array $data)
    {
        $endereco = $this->find($id);
        $endereco->update($data);
        return $endereco;
    }

    public function delete($id)
    {
        $endereco = $this->find($id);
        return $endereco->delete();
    }
}

<?php

namespace App\Repositories;

use App\Models\Endereco;

class EnderecoRepository
{
    public function all()
    {
        return Endereco::with('user')->get();
    }

    public function find($id)
    {
        return Endereco::with('user')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Endereco::create($data);
    }

    public function update($id, array $data)
    {
        $endereco = $this->find($id);
        $endereco->update($data);
        return $endereco;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}

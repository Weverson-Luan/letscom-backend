<?php

namespace App\Repositories;

use App\Models\UserAtendimento;

class UserAtendimentoRepository
{
    public function all()
    {
        return UserAtendimento::with('cliente')->get();
    }

    public function find($id)
    {
        return UserAtendimento::with('cliente')->findOrFail($id);
    }

    public function create(array $data)
    {
        return UserAtendimento::create($data);
    }

    public function update($id, array $data)
    {
        $atendimento = $this->find($id);
        $atendimento->update($data);
        return $atendimento;
    }

    public function delete($id)
    {
        $atendimento = $this->find($id);
        return $atendimento->delete();
    }
}

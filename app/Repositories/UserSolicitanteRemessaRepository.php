<?php

namespace App\Repositories;

use App\Models\UserSolicitanteRemessa;

class UserSolicitanteRemessaRepository
{
    public function create(array $data): UserSolicitanteRemessa
    {
        return UserSolicitanteRemessa::create($data);
    }

    public function all()
    {
        return UserSolicitanteRemessa::with(['remessa', 'user'])->get();
    }
}

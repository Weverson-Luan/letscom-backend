<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\RoleRepository;

class RoleService
{
    protected $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listRoles()
    {
        return $this->repository->all();
    }

    public function createRole(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateRole($id, array $data)
    {
        $role = $this->repository->find($id);
        return $this->repository->update($role, $data);
    }

    public function deleteRole($id)
    {
        $role = $this->repository->find($id);
        return $this->repository->delete($role);
    }
}

<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function paginateWithRelations(array $params)
    {
        return User::with(['consultor', 'produto'])->paginate($params['per_page'] ?? 15);
    }

    public function paginate(array $params): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($params['search'])) {
            $query->where(function($q) use ($params) {
                $q->where('nome', 'like', "%{$params['search']}%")
                  ->orWhere('email', 'like', "%{$params['search']}%")
                  ->orWhere('documento', 'like', "%{$params['search']}%");
            });
        }

        return $query->orderBy(
            $params['sort_by'] ?? 'created_at',
            $params['order'] ?? 'desc'
        )->paginate($params['per_page'] ?? 10);
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function findWithPermissions($id): ?User
    {
        return $this->model->with('permissions')->find($id);
    }

    public function findByemail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function findByCpf(string $cpf): ?User
    {
        return $this->model->where('cpf', $cpf)->first();
    }
}

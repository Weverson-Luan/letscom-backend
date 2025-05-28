<?php

namespace App\Repositories;

use App\Models\Endereco;
use Illuminate\Pagination\LengthAwarePaginator;

class EnderecoRepository
{
    protected $model;

    public function __construct(Endereco $model)
    {
        $this->model = $model;
    }

    public function buscarTodosEnderecos(array $params): LengthAwarePaginator
    {
        $query = $this->model->query();

        return $query->orderBy(
            $params['sort_by'] ?? 'created_at',
            $params['order'] ?? 'desc'
        )->paginate($params['per_page'] ?? 10);
    }

    public function find($id)
    {
        return Endereco::with('user')->findOrFail($id);
    }

    public function buscarEnderecosPorUsuarioESepararPorTipo(int $userId, array $params): array
    {
        $query = Endereco::where('user_id', $userId)
            ->with('user')
            ->orderBy($params['sort_by'] ?? 'created_at', $params['order'] ?? 'desc');

        $enderecos = $query->get(); // Sem paginação aqui, pois você quer retornar dois apenas

        return [
            'residencial' => $enderecos->firstWhere('tipo_endereco', 'residencial'),
            'entrega'     => $enderecos->firstWhere('tipo_endereco', 'entrega'),
        ];
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

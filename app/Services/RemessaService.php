<?php

namespace App\Services;

use App\Models\Remessa;
use App\Models\User;
use App\Repositories\RemessaRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RemessaService
{
    protected RemessaRepository $repository;

    public function __construct(RemessaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(array $params): LengthAwarePaginator
    {
        try {
            return $this->repository->paginate($params);
        } catch (\Throwable $e) {
            Log::error('Erro ao listar remessas: ' . $e->getMessage());
            throw $e;
        }
    }

    public function create(array $data): Remessa
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($data['user_id']);

            $remessa = $this->repository->create([
                'user_id' => $user->id,
                'user_id_solicitante_remessa' => $data['user_id_solicitante_remessa'] ?? null,
                'user_id_executor' => $data['user_id_executor'] ?? null,
                'modelo_tecnico_id' => $data['modelo_tecnico_id'],
                'tecnologia_id' => $data['tecnologia_id'],
                'total_solicitacoes' => $data['total_solicitacoes'],
                'situacao' => $data['situacao'],
                'data_remessa' => $data['data_remessa'],
                'data_inicio_producao' => $data['data_inicio_producao'],
                'posicao' => $data['posicao'],
            ]);

            DB::commit();
            return $remessa;
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Erro ao criar remessa: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(Remessa $remessa, array $data): bool
    {
        try {

            if ($remessa->situacao === 'confirmado') {
                throw new \Exception('Não é possível alterar uma remessa já confirmada');
            }

            DB::beginTransaction();

            if (isset($data['situacao']) && $data['situacao'] === 'confirmado') {
                // lógica adicional se necessário
            }

            $success = $this->repository->update($remessa, $data);

            DB::commit();
            return $success;
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar remessa: ' . $e->getMessage());
            throw $e;
        }
    }

    public function delete(Remessa $remessa): bool
    {
        try {
            if ($remessa->situacao === 'confirmado') {
                throw new \Exception('Não é possível excluir uma remessa já confirmada');
            }

            DB::beginTransaction();

            // remove itens relacionados
            $remessa->items()->delete();

            $success = $this->repository->delete($remessa);

            DB::commit();
            return $success;
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Erro ao excluir remessa: ' . $e->getMessage());
            throw $e;
        }
    }

    public function listBySituacao(array $params): LengthAwarePaginator
    {
        return $this->repository->findBySituacaoPaginate($params);
    }

    public function listarDisponiveisParaProducao(array $params)
    {
        return $this->repository->getRemessasDisponiveisParaProducao($params);
    }

    public function listarMinhasTarefas(array $params)
    {
        return $this->repository->getMinhasTarefas($params);
    }

    public function listarTarefasEmExpedicao(array $params)
    {
        return $this->repository->getRemessasEmExpedicoes($params);
    }
}

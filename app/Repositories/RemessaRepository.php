<?php

namespace App\Repositories;

use App\Models\Remessa;
use Illuminate\Pagination\LengthAwarePaginator;

class RemessaRepository
{
    protected Remessa $model;

    public function __construct(Remessa $model)
    {
        $this->model = $model;
    }

    /**
     * Lista remessas com paginação e filtros
     */
    public function paginate(array $params): LengthAwarePaginator
    {
        $query = $this->model->query();

        $userAutenticado = auth()->user();


        if ($userAutenticado) {
            $role = strtolower($userAutenticado->roles()->first()?->nome ?? '');

            /**
             * USUÁRIO CLIENTE DEVE RETORNA TODAS REMESSAS
             */
            if ($role === 'cliente') {
                $query->where('user_id', $userAutenticado->id);
            }


            /**
             *  USUÁRIO VALIDAÇÕES ['expedição', 'produção', 'recepção']
             */
            if (in_array($role, ['expedição', 'produção', 'recepção'])) {

                /**
                 * USUÁRIO PARA EXPEDIÇÃO DEVE RETORNA O STATUS ['expedição']
                 */
                if ($role === 'expedição') {
                    $query->where('situação', 'expedição');
                }

                /**
                 * USUÁRIO PARA PRODUCAO DEVE RETORNA O STATUS ['envios_dados', 'em_producao']
                 */
                if ($role === 'produção') {
                    $query->whereIn('situacao', ['em_producao', "pendente"]);
                }

                /**
                 * USUÁRIO PARA PRODUCAO DEVE RETORNA O STATUS ['pedido_liberado']
                 */
                if ($role === 'recepção') {
                    $query->where('situacao', 'pedido_liberado');
                }
            }

        }

        return $query
            ->when(!empty($params['search']), function ($q) use ($params) {
                $q->whereHas('client', function ($query) use ($params) {
                    $query->where('nome', 'like', '%' . $params['search'] . '%');
                });
            })
            ->orderBy($params['sort_by'] ?? 'created_at', $params['order'] ?? 'desc')
            ->paginate($params['per_page'] ?? 10);
    }

    /**
     * Cria uma nova remessa
     */
    public function create(array $data): Remessa
    {
        return $this->model->create($data);
    }

    /**
     * Busca uma remessa pelo ID
     */
    public function find(int $id): ?Remessa
    {
        return $this->model->with(['client', 'items.product'])->find($id);
    }

    /**
     * Busca remessas disponiveis para usuários
     */
    public function getRemessasDisponiveisParaProducao(array $params): LengthAwarePaginator
    {
        $query = $this->model
            ->with(['tecnologia', 'modeloTecnico', 'user'])
            ->where('situacao', 'pendente')
            ->whereNull('user_id_executor'); // ← garante que não foi atribuida a aoguem

        /**
         * QUANDO FRONT END MANDAR O CAMPO SEARCH
         */
        $query->when(!empty($params['search']), function ($q) use ($params) {
            $q->where(function ($sub) use ($params) {
                $sub->where('situacao', 'like', '%' . $params['search'] . '%')
                 ->orWhere('id', $params['search']) // busca por ID exato
                 ->orWhereHas('user', function ($query) use ($params) {
                $query->where('nome', 'like', '%' . $params['search'] . '%');
            });
            });
        });

        /**
         * ORDENAÇÃO DO MAIS RECENTES PARA OS MAIS ANTIGOS
         */
        return $query->orderBy('created_at', 'desc')
            ->paginate($params['per_page'] ?? 10, ['*'], 'page', $params['page'] ?? 1);
    }

    /**
     * Busca remessas que o usuário pegou (executor):
     */
    public function getMinhasTarefas(array $params)
    {
        $userAutenticado = auth()->user();

        $query = $this->model
            ->with(['tecnologia', 'modeloTecnico', 'user'])
            ->whereNotNull('user_id_executor') // ← garante que só retorne tarefas já atribuídas
            ->where('situacao', 'em_producao'); // ← garante que estejam em produção

        /**
         * VALIDAÇÃO PARA SABER SE O USUÁRIO É ADMIN
         */
        if ($userAutenticado) {
            $role = strtolower($userAutenticado->roles()->first()?->nome ?? '');

            // 🔒 Apenas restringe por executor se NÃO for admin
            if ($role !== 'admin') {
                $query->where('user_id_executor', $userAutenticado->id);
            }
        }

        /**
         * FILTRO DE BUSCA PELO FRONT
         */
        $query->when(!empty($params['search']), function ($q) use ($params) {
            $q->where(function ($sub) use ($params) {
                $sub->where('situacao', 'like', '%' . $params['search'] . '%')
                    ->orWhere('id', $params['search']) // busca direta por ID
                    ->orWhereHas('user', function ($query) use ($params) {
                        $query->where('nome', 'like', '%' . $params['search'] . '%');
                    });
            });
        });

        /**
         * ORDENAÇÃO DO MAIS RECENTE PARA O MAIS ANTIGO
         */
        return $query->orderBy('created_at', 'desc')
            ->paginate($params['per_page'] ?? 10, ['*'], 'page', $params['page'] ?? 1);
    }

     /**
     * Busca remessas que estão em expedições
     */
    public function getRemessasEmExpedicoes(array $params)
    {
        $userAutenticado = auth()->user();

        $query = $this->model
            ->with(['tecnologia', 'modeloTecnico', 'user'])
            ->where('situacao', 'concluida') // ← adiciona esse filtro fixo
            ->whereNotNull('user_id_executor'); // ← garante que só retorne tarefas já atribuídas

        /**
         * VALIDAÇÃO PARA SABER SE O USUÁRIO É ADMIN
         */
        if ($userAutenticado) {
            $role = strtolower($userAutenticado->roles()->first()?->nome ?? '');

            // 🔒 Apenas restringe por executor se NÃO for admin
            if ($role !== 'admin') {
                $query->where('user_id_executor', $userAutenticado->id);
            }
        }

        /**
         * QUANDO FRONT END MANDAR O CAMPO SEARCH
         */
        $query->when(!empty($params['search']), function ($q) use ($params) {
            $q->where(function ($sub) use ($params) {
                $sub->where('situacao', 'like', '%' . $params['search'] . '%')
                    ->orWhere('id', $params['search']) // busca direta por ID
                    ->orWhereHas('user', function ($query) use ($params) {
                        $query->where('nome', 'like', '%' . $params['search'] . '%');
                    });
            });
        });

        /**
         * ORDENAÇÃO DO MAIS RECENTES PARA OS MAIS ANTIGOS
         */
        return $query->orderBy('created_at', 'desc')
            ->paginate($params['per_page'] ?? 10, ['*'], 'page', $params['page'] ?? 1);
    }


    /**
     * Atualiza uma remessa
     */
    public function update(Remessa $remessa, array $data): bool
    {
        return $remessa->update($data);
    }

    /**
     * Remove uma remessa
     */
    public function delete(Remessa $remessa): bool
    {
        return $remessa->delete();
    }
}

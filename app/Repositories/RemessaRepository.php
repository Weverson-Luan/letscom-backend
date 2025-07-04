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
     * Cria uma nova remessa
     */
    public function create(array $data): Remessa
    {
        return $this->model->create($data);
    }


    /**
     * Busca remessas com paginação e filtros
     */
    public function paginate(array $params): LengthAwarePaginator
    {
        $query = $this->model->query();

        $userAutenticado = \Illuminate\Support\Facades\Auth::user();


        if ($userAutenticado) {
            $role = strtolower($userAutenticado->roles->first()?->nome ?? '');
            /**
             * USUÁRIO CLIENTE DEVE RETORNA TODAS REMESSAS
             */
            if ($role === 'cliente') {
                $query->where('user_id', $userAutenticado->id);
            }


            /**
             *  USUÁRIO VALIDAÇÕES ['pedido_liberado', 'produção', 'recepção']
             */
            if (in_array($role, ['pedido_liberado', 'produção', 'recepção'])) {

                /**
                 * USUÁRIO PARA EXPEDIÇÃO DEVE RETORNA O STATUS ['pedido_liberado']
                 */
                if ($role === 'pedido_liberado') {
                    $query->where('situação', 'pedido_liberado');
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
                $q->whereHas('cliente', function ($query) use ($params) {
                    $query->where('nome', 'like', '%' . $params['search'] . '%');
                });
            })
            ->orderBy($params['sort_by'] ?? 'created_at', $params['order'] ?? 'desc')
            ->paginate($params['per_page'] ?? 10);
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
            ->with(['tecnologia', 'modeloTecnico', 'cliente'])
            ->where('status', 'solicitado') // ← garante que sejam remessas em expedição
            ->whereNull('user_id_executor'); // ← garante que não foi atribuida a aoguem

        /**
         * QUANDO FRONT END MANDAR O CAMPO SEARCH
         */
        $query->where(function ($q) use ($params) {
            $search = $params['search'] ?? null;

            if (!empty($search)) {
                $q->where('situacao', 'like', "%{$search}%")
                    ->orWhere('id', $search)
                    ->orWhereHas('cliente', function ($query) use ($search) {
                        $query->where('nome', 'like', "%{$search}%");
                    });
            }
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
        $userAutenticado = \Illuminate\Support\Facades\Auth::user();

        $query = $this->model
            ->with(['tecnologia', 'modeloTecnico', 'cliente'])
            ->whereNotNull('user_id_executor') // ← garante que só retorne tarefas já atribuídas
            ->where('situacao', 'em_producao'); // ← garante que estejam em produção

        /**
         * VALIDAÇÃO PARA SABER SE O USUÁRIO É ADMIN
         */
        if ($userAutenticado) {
            $role = strtolower($userAutenticado->roles->first()?->nome ?? '');

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
                    ->orWhereHas('cliente', function ($query) use ($params) {
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
        $userAutenticado = \Illuminate\Support\Facades\Auth::user();

        $query = $this->model
            ->with(['tecnologia', 'modeloTecnico', 'cliente'])
            ->where('situacao', 'pedido_liberado')
            ->whereNotNull('user_id_executor');

        /**
         * VALIDAÇÃO PARA PERMITIR APENAS ADMIN OU EXPEDIÇÃO
         */
        if ($userAutenticado) {
            $role = strtolower($userAutenticado->roles->first()?->nome ?? '');

            if (!in_array($role, ['admin', 'expedicao'])) {
                // impede usuários não autorizados de acessarem os dados
                $empty = new LengthAwarePaginator(
                    collect([]), // dados
                    0,           // total
                    $params['per_page'] ?? 10,
                    $params['page'] ?? 1
                );
                return $empty; // retorna coleção vazia
            }
        }

        /**
         * QUANDO FRONT END MANDAR O CAMPO SEARCH
         */
        $query->when(!empty($params['search']), function ($q) use ($params) {
            $q->where(function ($sub) use ($params) {
                $sub->where('situacao', 'like', '%' . $params['search'] . '%')
                    ->orWhere('id', $params['search']) // busca direta por ID
                    ->orWhereHas('cliente', function ($query) use ($params) {
                        $query->where('nome', 'like', '%' . $params['search'] . '%');
                    });
            });
        });

        return $query->orderBy('created_at', 'desc')
            ->paginate($params['per_page'] ?? 10, ['*'], 'page', $params['page'] ?? 1);
    }

    /**
     * Busca remessas que estão prontas para entregar o cliente
     */
    public function getRemessasBalcao(array $params)
    {
        $userAutenticado = \Illuminate\Support\Facades\Auth::user();

        $query = $this->model
            ->with(['tecnologia', 'modeloTecnico', 'cliente'])
            ->where('situacao', 'conferido')
            ->where('status', 'conferido')
            ->whereNotNull('user_id_executor');

        /**
         * VALIDAÇÃO PARA PERMITIR APENAS ADMIN OU RECEPCAO
         */
        if ($userAutenticado) {
            $role = strtolower($userAutenticado->roles->first()?->nome ?? '');

            if (!in_array($role, ['admin', 'recepcao'])) {
                // impede usuários não autorizados de acessarem os dados
                $empty = new LengthAwarePaginator(
                    collect([]), // dados
                    0,           // total
                    $params['per_page'] ?? 10,
                    $params['page'] ?? 1
                );
                return $empty; // retorna coleção vazia
            }
        }

        /**
         * QUANDO FRONT END MANDAR O CAMPO SEARCH
         */
        $query->when(!empty($params['search']), function ($q) use ($params) {
            $q->where(function ($sub) use ($params) {
                $sub->where('situacao', 'like', '%' . $params['search'] . '%')
                    ->orWhere('id', $params['search']) // busca direta por ID
                    ->orWhereHas('cliente', function ($query) use ($params) {
                        $query->where('nome', 'like', '%' . $params['search'] . '%');
                    });
            });
        });

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

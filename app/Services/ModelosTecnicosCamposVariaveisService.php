<?php

namespace App\Services;

use App\Models\ModelosTecnicosCamposVariaveis;
use App\Repositories\ModelosTecnicosCamposVariaveisRepository;
use Illuminate\Support\Facades\Log;

class ModelosTecnicosCamposVariaveisService
{
    protected $repository;

    public function __construct(ModelosTecnicosCamposVariaveisRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Lista campos variáveis com paginação
     */
    public function list(array $params): array
    {
        try {
            $paginated = $this->repository->paginate($params);

            return [
                'code' => 200,
                'message' => 'Campos variáveis carregados com sucesso!',
                'data' => $paginated->items(),
                'pagination' => [
                    'current_page' => $paginated->currentPage(),
                    'last_page' => $paginated->lastPage(),
                    'per_page' => $paginated->perPage(),
                    'total' => $paginated->total(),
                ],
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao listar campos variáveis: ' . $e->getMessage());
            return [
                'code' => 500,
                'message' => 'Erro ao carregar campos variáveis.',
                'data' => [],
                'pagination' => null,
            ];
        }
    }

    /**
     * Cria um novo campo variável
     */
    public function create(array $data): array
    {
        $itensCriados = [];

        $campos = $data['campos'] ?? [];

        foreach ($campos as $item) {
            // Se foi enviado um ID e ele já existe, ignoramos
            if (!empty($item['id'])) {
                $existe = ModelosTecnicosCamposVariaveis::where('id', $item['id'])->exists();
                if ($existe) {
                    continue; // já existe, pula para o próximo
                }
            }
            //Cria apenas se não tem id ou não existe no banco
            $itensCriados[] = ModelosTecnicosCamposVariaveis::create([
                'modelo_tecnico_id' => $item['modelo_tecnico_id'],
                'nome' => $item['nome'],
                'obrigatorio' => $item['obrigatorio'] ?? false,
                "ordem" => $item["ordem"] ?? 0,
            ]);
        }

        return $itensCriados;
    }

    /**
     * Atualiza um campo variável
     */
    public function update(int $id, array $data): bool
    {
        $campo = $this->repository->find($id);
        return $campo ? $this->repository->update($campo, $data) : false;
    }

    private function reorganizarOrdem(int $modeloTecnicoId): void
    {
        $campos = ModelosTecnicosCamposVariaveis::where('modelo_tecnico_id', $modeloTecnicoId)
            ->orderBy('ordem')
            ->get();

        foreach ($campos as $index => $campo) {
            if ($campo->ordem !== $index) {
                $campo->update(['ordem' => $index]);
            }
        }
    }

    /**
     * Remove um campo variável
     */
    public function delete(int $id): bool
    {
        $campo = $this->repository->find($id);

        if (!$campo) {
            return false;
        }

        $modeloTecnicoId = $campo->modelo_tecnico_id;

        $this->repository->delete($campo);

        $this->reorganizarOrdem($modeloTecnicoId);

        return true;
    }
}

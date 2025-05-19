<?php

namespace App\Services;

use App\Models\ModeloTecnico;
use App\Models\ModelosTecnicosCamposVariaveis;
use App\Models\Product;
use App\Models\User;

use App\Repositories\ModeloTecnicosRepository;

use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class ModeloTecnicosService
{
    protected ModeloTecnicosRepository $repository;

    public function __construct(ModeloTecnicosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data): ModeloTecnico
    {
        try {
            return $this->repository->create($data);
        } catch (\Throwable $e) {
            Log::error('Erro ao criar modelo técnico: ' . $e->getMessage());
            throw $e;
        }
    }

    public function list(array $params): array
    {
        try {
            $modelosPaginados = $this->repository->paginate($params);
            $data = [];

            foreach ($modelosPaginados->items() as $modelo) {
                $camposVariaveis = ModelosTecnicosCamposVariaveis::where('modelo_tecnico_id', $modelo->id)->get();
                $produto = Product::find($modelo->produto_id);
                $cliente = User::find($modelo->user_id);

                $data[] = [
                    'id' => $modelo->id,
                    'nome_modelo' => $modelo->nome_modelo,
                    'tipo_entrega' => $modelo->tipo_entrega,
                    'posicionamento' => $modelo->posicionamento,
                    'tem_furo' => $modelo->tem_furo,
                    'tem_carga_foto' => $modelo->tem_carga_foto,
                    'tem_dados_variaveis' => $modelo->tem_dados_variaveis,
                    'campo_chave' => $modelo->campo_chave,
                    'foto_frente_path' => $modelo->foto_frente_path,
                    'foto_verso_path' => $modelo->foto_verso_path,
                    'observacoes' => $modelo->observacoes,
                    'cliente' => $cliente ?? null,
                    'produtos' => $produto ?? null,
                    'campos_variaveis' => $camposVariaveis,
                    'created_at' => $modelo->created_at,
                    'updated_at' => $modelo->updated_at,
                ];
            }

            return [
                'code' => 200,
                'message' => 'Modelos carregados com sucesso!',
                'data' => $data,
                'pagination' => [
                    'current_page' => $modelosPaginados->currentPage(),
                    'last_page' => $modelosPaginados->lastPage(),
                    'per_page' => $modelosPaginados->perPage(),
                    'total' => $modelosPaginados->total(),
                ],
            ];
        } catch (\Throwable $e) {
            Log::error('Erro ao listar modelos técnicos: ' . $e->getMessage());
            throw $e;
        }
    }

    public function listPorUsuario(array $params): array
    {
        try {
            $modelosPaginados = $this->repository->buscarPorCliente($params);
            $data = [];

            foreach ($modelosPaginados->items() as $modelo) {
                $camposVariaveis = ModelosTecnicosCamposVariaveis::where('modelo_tecnico_id', $modelo->id)->get();
                $produto = Product::find($modelo->produto_id);
                $cliente = User::find($modelo->user_id);

                $data[] = [
                    'id' => $modelo->id,
                    'nome_modelo' => $modelo->nome_modelo,
                    'tipo_entrega' => $modelo->tipo_entrega,
                    'posicionamento' => $modelo->posicionamento,
                    'tem_furo' => $modelo->tem_furo,
                    'tem_carga_foto' => $modelo->tem_carga_foto,
                    'tem_dados_variaveis' => $modelo->tem_dados_variaveis,
                    'campo_chave' => $modelo->campo_chave,
                    'foto_frente_path' => $modelo->foto_frente_path,
                    'foto_verso_path' => $modelo->foto_verso_path,
                    'observacoes' => $modelo->observacoes,
                    'cliente' => $cliente ?? null,
                    'produtos' => $produto ?? null,
                    'campos_variaveis' => $camposVariaveis,
                    'created_at' => $modelo->created_at,
                    'updated_at' => $modelo->updated_at,
                ];
            }

            return [
                'code' => 200,
                'message' => 'Modelos carregados com sucesso!',
                'data' => $data,
                'pagination' => [
                    'current_page' => $modelosPaginados->currentPage(),
                    'last_page' => $modelosPaginados->lastPage(),
                    'per_page' => $modelosPaginados->perPage(),
                    'total' => $modelosPaginados->total(),
                ],
            ];
        } catch (\Throwable $e) {
            Log::error('Erro ao listar modelos técnicos por usuário: ' . $e->getMessage());
            throw $e;
        }
    }


    public function find(int $id): ModeloTecnico
    {
        return $this->repository->find($id) ?? throw new \Exception('Modelo técnico não encontrado');
    }

    public function update(int $id, array $data): ModeloTecnico
    {
        $modelo = $this->repository->find($id);

        if (!$modelo) {
            throw new \Exception('Modelo técnico não encontrado');
        }

        $this->repository->update($modelo, $data);

        return $modelo;
    }

    public function delete(int $id): bool
    {
        $modelo = $this->repository->find($id);

        if (!$modelo) {
            throw new \Exception('Modelo técnico não encontrado');
        }

        return $this->repository->delete($modelo);
    }
}

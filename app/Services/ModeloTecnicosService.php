<?php
namespace App\Services;

use App\Models\ModeloTecnico;
use App\Models\ModelosTecnicosCamposVariaveis;
use App\Models\Product;
use App\Models\Client;

use App\Repositories\ModeloTecnicosRepository;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ModeloTecnicosService
{

    protected $repository;

    public function __construct(ModeloTecnicosRepository $repository)
    {
        $this->repository = $repository;
    }


    public function create(array $data): ModeloTecnico
    {
        return ModeloTecnico::create($data);
    }

    public function list(array $params): array
    {
        $query = ModeloTecnico::query();

        // 🔍 Filtro por nome_modelo
        if (!empty($params['nome_modelo'])) {
            $query->where('nome_modelo', 'like', '%' . $params['nome_modelo'] . '%');
        }

        // 🔃 Ordenação
        $order = in_array($params['order'] ?? '', ['asc', 'desc']) ? $params['order'] : 'desc';
        $query->orderBy('created_at', $order);

        // 📄 Paginação
        $perPage = isset($params['per_page']) && is_numeric($params['per_page']) ? (int)$params['per_page'] : 10;
        $modelosTecnicos = $query->paginate($perPage);

        // 📦 Montar resposta incluindo os campos_variaveis
        $data = [];

        foreach ($modelosTecnicos->items() as $modelo) {
            $camposVariaveis = ModelosTecnicosCamposVariaveis::where('modelo_tecnico_id', $modelo->id)->get();
            $produto = Product::find($modelo->produto_id);
            $cliente = Client::find($modelo->cliente_id);

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
                'cliente' => $cliente ? $cliente : [],
                'produtos' => $produto ? $produto : [],
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
                'current_page' => $modelosTecnicos->currentPage(),
                'last_page' => $modelosTecnicos->lastPage(),
                'per_page' => $modelosTecnicos->perPage(),
                'total' => $modelosTecnicos->total()
            ]
        ];
    }


    public function find($id)
    {
        return ModeloTecnico::findOrFail($id);
    }

    public function update($id, array $data): ModeloTecnico
    {
        $modelo = ModeloTecnico::findOrFail($id);
        $modelo->update($data);
        return $modelo;
    }

    public function delete($id): bool
    {
        return ModeloTecnico::destroy($id);
    }
}

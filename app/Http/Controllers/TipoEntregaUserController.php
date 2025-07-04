<?php


namespace App\Http\Controllers;

use App\Helpers\UsersResponseHelper;

use App\Services\TipoEntregaUserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class TipoEntregaUserController extends Controller
{
    protected $service;

    public function __construct(TipoEntregaUserService $service)
    {
        $this->service = $service;
    }

    public function vincular(Request $request)
    {
        $result = $this->service->vincularTiposEntrega($request->cliente_id, $request->tipo_entrega_id);

        return response()->json(['message' => 'Vínculo criado com sucesso', 'data' => $result]);
    }

    public function atualizarTipoEntrega(Request $request)
    {

        try {
            $data = $this->service->atualizarTipoEntrega(
                $request->cliente_id,
                $request->tipo_entrega_id,
            );



            return response()->json($data, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tipo de entrega informado não existe.',
            ], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro inesperado ao atualizar tipo de entrega.',
                'error' => $e->getMessage(), // remova em produção se for sensível
            ], 500);
        }
    }

    public function listar($userId)
    {
        return response()->json($this->service->listarPorUsuario($userId));
    }
}

<?php


namespace App\Http\Controllers;
use App\Helpers\UsersResponseHelper;

use App\Services\TipoEntregaUserService;

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

    public function listar($userId)
    {
        return response()->json($this->service->listarPorUsuario($userId));
    }
}

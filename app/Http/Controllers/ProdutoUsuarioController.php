<?php

namespace App\Http\Controllers;

use App\Services\ProdutoUsuarioService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProdutoUsuarioController extends Controller
{
    protected ProdutoUsuarioService $service;

    public function __construct(ProdutoUsuarioService $service)
    {
        $this->service = $service;
    }

    public function vincular(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'produto_id' => 'required|integer|exists:produtos,id',
        ]);

        $this->service->vincularProduto($request->user_id, $request->produto_id);

        return response()->json(['message' => 'Produto vinculado com sucesso.']);
    }

    public function desvincular(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'produto_id' => 'required|integer|exists:produtos,id',
        ]);

        $this->service->desvincularProduto($request->user_id, $request->produto_id);

        return response()->json(['message' => 'Produto desvinculado com sucesso.']);
    }

    public function listar(int $userId): JsonResponse
    {
        $produtos = $this->service->listarProdutosVinculados($userId);
        return response()->json(['produtos' => $produtos]);
    }
}

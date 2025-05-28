<?php

namespace App\Services;

use App\Repositories\ProdutoUsuarioRepository;

class ProdutoUsuarioService
{
    protected ProdutoUsuarioRepository $repository;

    public function __construct(ProdutoUsuarioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function vincularProduto(int $userId, int $produtoId): bool
    {
        return $this->repository->vincularProduto($userId, $produtoId);
    }

    public function desvincularProduto(int $userId, int $produtoId): bool
    {
        return $this->repository->desvincularProduto($userId, $produtoId);
    }

    public function listarProdutosVinculados(int $userId)
    {
        return $this->repository->listarProdutosVinculados($userId);
    }
}

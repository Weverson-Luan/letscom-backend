<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Product;

class ProdutoUsuarioRepository
{
    public function vincularProduto(int $userId, int $produtoId): bool
    {
        $user = User::findOrFail($userId);
        $user->produtosVinculados()->syncWithoutDetaching([$produtoId]);

        return true;
    }

    public function desvincularProduto(int $userId, int $produtoId): bool
    {
        $user = User::findOrFail($userId);
        $user->produtosVinculados()->detach($produtoId);

        return true;
    }

    public function listarProdutosVinculados(int $userId)
    {
        return User::with('produtosVinculados')->findOrFail($userId)->produtosVinculados;
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DatabaseConnectionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CreditSaleController;
use App\Http\Controllers\RemessaController;
use App\Http\Middleware\RateLimitPerUser;
use App\Http\Controllers\UserController;

/**
 * Rotas da API do Sistema de Gerenciamento de Créditos
 *
 * Este arquivo contém todas as rotas da API, organizadas em grupos públicos e protegidos.
 * As rotas protegidas requerem autenticação JWT e verificação de permissões.
 *
 * @package App\Routes
 * @version 1.0.0
 */

/**
 * Rotas públicas
 * Estas rotas não requerem autenticação
 */
Route::get('/testar_conexao', [DatabaseConnectionController::class, 'checkConnection']);
Route::post('/login', [AuthController::class, 'login'])->middleware(RateLimitPerUser::class);

/**
 * Rotas protegidas
 * Grupo de rotas que requerem autenticação JWT
 *
 * @middleware auth.jwt
 */
Route::middleware(['auth.jwt'])->group(function () {
    /**
     * Rotas de Clientes
     * Gerenciamento completo de clientes (CRUD)
     *
     * @prefix clients
     * @middleware permission
     */
    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->middleware('permission:clients,R');
        Route::post('/', [ClientController::class, 'store'])->middleware('permission:clients,C');
        Route::get('/{client}', [ClientController::class, 'show'])->middleware('permission:clients,R');
        Route::put('/{client}', [ClientController::class, 'update'])->middleware('permission:clients,U');
        Route::delete('/{client}', [ClientController::class, 'destroy'])->middleware('permission:clients,D');
    });

    /**
     * Rotas de Produtos
     * Gerenciamento completo de produtos (CRUD)
     *
     * @prefix products
     * @middleware permission
     */
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->middleware('permission:products,R');
        Route::post('/', [ProductController::class, 'store'])->middleware('permission:products,C');
        Route::get('/{product}', [ProductController::class, 'show'])->middleware('permission:products,R');
        Route::put('/{product}', [ProductController::class, 'update'])->middleware('permission:products,U');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->middleware('permission:products,D');
    });

    /**
     * Rotas de Vendas de Créditos
     * Gerenciamento de vendas de créditos para clientes
     *
     * @prefix credit-sales
     * @middleware permission
     */
    Route::prefix('credit-sales')->group(function () {
        Route::get('/', [CreditSaleController::class, 'index'])->middleware('permission:credit_sales,R');
        Route::post('/', [CreditSaleController::class, 'store'])->middleware('permission:credit_sales,C');
        Route::get('/{creditSale}', [CreditSaleController::class, 'show'])->middleware('permission:credit_sales,R');
        Route::put('/{creditSale}', [CreditSaleController::class, 'update'])->middleware('permission:credit_sales,U');
        Route::delete('/{creditSale}', [CreditSaleController::class, 'destroy'])->middleware('permission:credit_sales,D');
    });

    /**
     * Rotas de Remessas
     * Gerenciamento de remessas de produtos
     *
     * @prefix remessas
     * @middleware permission
     */
    Route::prefix('remessas')->group(function () {
        Route::get('/', [RemessaController::class, 'index'])->middleware('permission:remessas,R');
        Route::post('/', [RemessaController::class, 'store'])->middleware('permission:remessas,C');
        Route::get('/{remessa}', [RemessaController::class, 'show'])->middleware('permission:remessas,R');
        Route::put('/{remessa}', [RemessaController::class, 'update'])->middleware('permission:remessas,U');
        Route::delete('/{remessa}', [RemessaController::class, 'destroy'])->middleware('permission:remessas,D');
    });

    /**
     * Rotas de Usuários
     * Gerenciamento completo de usuários (CRUD)
     *
     * @prefix users
     * @middleware permission
     */
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->middleware('permission:users,R');
        Route::post('/', [UserController::class, 'store'])->middleware('permission:users,C');
        Route::get('/{user}', [UserController::class, 'show'])->middleware('permission:users,R');
        Route::put('/{user}', [UserController::class, 'update'])->middleware('permission:users,U');
        Route::delete('/{user}', [UserController::class, 'destroy'])->middleware('permission:users,D');
    });
});

/**
 * Rota de fallback
 * Retorna erro 404 para rotas não encontradas
 *
 * @return \Illuminate\Http\JsonResponse
 */
Route::fallback(function () {
    return response()->json(['error' => 'Rota não encontrada'], 404);
});

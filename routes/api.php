<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseConnectionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CreditSaleController;
use App\Http\Controllers\RemessaController;
use App\Http\Middleware\RateLimitPerUser;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModeloTecnicosController;
use App\Http\Controllers\ModelosTecnicosCamposVariaveisController;
use App\Http\Controllers\RemessaFotoController;
use App\Http\Controllers\RemessaPlanilhaController;
use App\Http\Controllers\UserAtendimentoController;
use App\Http\Controllers\EnderecoEntregaController;
use App\Http\Controllers\TipoEntregaController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\UserClienteController;
use App\Http\Controllers\TecnologiasController;
use App\Http\Controllers\EntregaClienteController;
use App\Http\Controllers\ProdutoUsuarioController;
use App\Http\Controllers\TipoEntregaUserController;
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


    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::post('/', [RoleController::class, 'store']);
    });

    /**
     * Rotas de Produtos
     * Gerenciamento completo de produtos (CRUD)
     *
     * @prefix products
     * @middleware permission
     */
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/', [ProductController::class, 'store']);
        Route::get('/{product}', [ProductController::class, 'show']);
        Route::put('/{product}', [ProductController::class, 'update']);
        Route::delete('/{product}', [ProductController::class, 'destroy']);
    });

    /**
     * Rotas de Vendas de Créditos
     * Gerenciamento de vendas de créditos para clientes
     *
     * @prefix credit-sales
     * @middleware permission
     */
    Route::prefix('vendas_creditos')->group(function () {
        Route::get('/', [CreditSaleController::class, 'index']);
        Route::get('/cliente/{id}', [CreditSaleController::class, 'buscarTransacoesPorCliente']);
        Route::post('/', [CreditSaleController::class, 'store']);
        Route::get('/{creditSale}', [CreditSaleController::class, 'show']);
        Route::put('/{creditSale}', [CreditSaleController::class, 'update']);
        Route::delete('/{creditSale}', [CreditSaleController::class, 'destroy']);
    });



    /**
     * Rotas de Remessas
     * Gerenciamento de remessas de produtos
     *
     * @prefix remessas
     * @middleware permission
     */
    Route::prefix('remessas')->group(function () {
            // 👤 Cliente: Cria remessa e consulta status
        Route::get('/', [RemessaController::class, 'index'])->middleware('role:cliente,admin,producao');
        Route::post('/', [RemessaController::class, 'store'])->middleware('role:cliente,admin');

        // Usuários com acesso para produzir
        Route::get('/tarefas-disponiveis', [RemessaController::class, 'tarefasDisponiveis'])->middleware('role:admin,producao');
        Route::get('/minhas-tarefas', [RemessaController::class, 'minhasTarefas']);
        Route::get('/tarefas-expedicoes', [RemessaController::class, 'tarefasEmExpedicao'])->middleware('role:admin,producao');
        // 📷 Uploads (liberado para admin e produção se necessário)
        Route::post('/{remessa}/upload-fotos', [RemessaFotoController::class, 'store'])->middleware('role:admin,producao');
        Route::post('/{remessa}/upload-planilha', [RemessaPlanilhaController::class, 'store'])->middleware('role:admin,producao');


        // 📄 Detalhes da remessa
        Route::get('/{remessa}', [RemessaController::class, 'show'])->middleware('role:admin,cliente');

        // ✏️ Atualização e exclusão (restrito a admin)
        Route::put('/{id}', [RemessaController::class, 'update'])->middleware('role:admin,producao');
        Route::delete('/{remessa}', [RemessaController::class, 'destroy'])->middleware('role:admin');

        // // 🚦 Transições de status protegidas por role específica
        // Route::post('/{remessa}/produzir', [RemessaStatusController::class, 'produzir'])->middleware('role:producao');
        // Route::post('/{remessa}/expedir', [RemessaStatusController::class, 'expedir'])->middleware('role:producao');
        // Route::post('/{remessa}/liberar', [RemessaStatusController::class, 'liberar'])->middleware('role:expedicao');
        // Route::post('/{remessa}/finalizar', [RemessaStatusController::class, 'finalizar'])->middleware('role:recepcao');
    });


      /**
     * Rotas de Modelos
     * Gerenciamento de modelos
     *
     * @prefix Modelos
     * @middleware permission
     */
    Route::prefix('modelo-tecnico')->group(function () {
        Route::get('/', [ModeloTecnicosController::class, 'index'])->middleware('role:admin,cliente,producao');
        Route::get('/clientes/{id}', [ModeloTecnicosController::class, 'buscarPorUsuarios'])->middleware('role:admin,cliente,producao');
        Route::post('/', [ModeloTecnicosController::class, 'store'])->middleware('role:admin,cliente,producao');
        Route::get('/{id}', [ModeloTecnicosController::class, 'show']);
        Route::post('/{id}', [ModeloTecnicosController::class, 'atualizarModelo'])->middleware('role:admin,cliente,producao');
        Route::delete('/{id}', [ModeloTecnicosController::class, 'destroy'])->middleware('role:admin,cliente,producao');
    });


    /**
     * Rotas de Campos Variaveis para modelos
     * Gerenciamento de campos variaveis para modelos
     *
     * @prefix Campos Variaveis
     * @middleware permission
     */
    Route::prefix('modelos-tecnicos-campos-variaveis')->group(function () {
        Route::get('/', [ModelosTecnicosCamposVariaveisController::class, 'index']);
        Route::post('/', [ModelosTecnicosCamposVariaveisController::class, 'store'])->middleware('role:admin,cliente');
        Route::get('/{id}', [ModelosTecnicosCamposVariaveisController::class, 'show']);
        Route::put('/{id}', [ModelosTecnicosCamposVariaveisController::class, 'update'])->middleware('role:admin,cliente');
        Route::delete('/{id}', [ModelosTecnicosCamposVariaveisController::class, 'destroy'])->middleware('role:admin,cliente');
    });


    /**
     * Rotas de Usuários
     * Gerenciamento completo de usuários (CRUD)
     *
     * @prefix users
     * @middleware permission
     */
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'buscarClientes']);
        Route::get('/consultores', [UserController::class, 'buscarUsuariosConsultores']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{user}', [UserController::class, 'buscarPorUmUsuario']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

    /**
     * Rotas de Endereços de entregas
     * Gerenciamento de endereços de entrega (CRUD)
     *
     * @prefix enderecos-entrega
     * @middleware permission
     */
    Route::prefix('enderecos-entrega')->group(function () {
        Route::get('/', [EnderecoEntregaController::class, 'index']);
        Route::post('/', [EnderecoEntregaController::class, 'store']);
        Route::get('/{id}', [EnderecoEntregaController::class, 'show']);
        Route::put('/{id}', [EnderecoEntregaController::class, 'update']);
        Route::delete('/{id}', [EnderecoEntregaController::class, 'destroy']);
    });


    /**
     * Rotas de Usuários que fazem atendimentos dos clientes
     * Gerenciamento de  Usuários que fazem atendimentos (CRUD)
     *
     * @prefix users-atendimentos
     * @middleware permission
     */
    Route::prefix('users-atendimentos')->group(function () {
        Route::get('/', [UserAtendimentoController::class, 'index']);
        Route::post('/', [UserAtendimentoController::class, 'store']);
        Route::get('/{id}', [UserAtendimentoController::class, 'show']);
        Route::put('/{id}', [UserAtendimentoController::class, 'update']);
        Route::delete('/{id}', [UserAtendimentoController::class, 'destroy']);
    });

    Route::prefix('usuarios-cliente')->group(function () {
        Route::get('/', [UserClienteController::class, 'index']);        // Listar todos
        Route::get('/{id}', [UserClienteController::class, 'show']);     // Detalhar um
        Route::get('/cliente/{id}', [UserClienteController::class, 'buscarUsuariosPorCliente']);
        Route::post('/', [UserClienteController::class, 'store']);       // Criar
        Route::put('/{id}', [UserClienteController::class, 'update']);   // Atualizar
        Route::delete('/{id}', [UserClienteController::class, 'destroy']); // Deletar
    });


     /**
     * Rotas de tipos de entregas
     * Gerenciamento de tipos de entregas (CRUD)
     *
     * @prefix tipos-entrega
     * @middleware permission
     */
    Route::prefix('tipos-entrega')->group(function () {
        Route::get('/', [TipoEntregaController::class, 'index']);
        Route::get('/usuarios/{id}', [TipoEntregaUserController::class, 'listar']);
        Route::post('/vincular-tipos-entrega/users', [TipoEntregaUserController::class, 'vincular']);
        Route::post('/atualizar/users', [TipoEntregaUserController::class, 'atualizarTipoEntrega']);
        Route::post('/', [TipoEntregaController::class, 'store']);
        Route::get('/{id}', [TipoEntregaController::class, 'show']);
        Route::put('/{id}', [TipoEntregaController::class, 'update']);
        Route::delete('/{id}', [TipoEntregaController::class, 'destroy']);
    });

     /**
     * Rotas de Endereços
     * Gerenciamento de endereços (CRUD)
     *
     * @prefix enderecos
     * @middleware permission
     */
    Route::prefix('enderecos')->group(function () {
        Route::get('/', [EnderecoController::class, 'index']);
        Route::get('/usuarios/{id}/enderecos-por-tipo', [EnderecoController::class, 'buscarEnderecosSeparados']);
        Route::post('/', [EnderecoController::class, 'store']);
        Route::get('/{id}', [EnderecoController::class, 'show']);
        Route::put('/{id}', [EnderecoController::class, 'update']);
        Route::delete('/{id}', [EnderecoController::class, 'destroy']);
    });


     /**
     * Rotas de Endereços
     * Gerenciamento de endereços (CRUD)
     *
     * @prefix enderecos
     * @middleware permission
     */
    Route::prefix('tecnologias')->group(function () {
        Route::get('/', [TecnologiasController::class, 'index']);
        Route::post('/', [TecnologiasController::class, 'store']);
        Route::get('/{id}', [TecnologiasController::class, 'show']);
        Route::put('/{id}', [TecnologiasController::class, 'update']);
        Route::delete('/{id}', [TecnologiasController::class, 'destroy']);
    });

        /**
     * Rotas de vincular produtos ao cliente
     * Gerenciamento de vincular produtos ao cliente (CRUD)
     *
     * @prefix vincular produtos ao cliente
     * @middleware permission
     */
    Route::prefix('produto-usuario')->group(function () {
        Route::post('/vincular', [ProdutoUsuarioController::class, 'vincular']);
        Route::post('/desvincular', [ProdutoUsuarioController::class, 'desvincular']);
        Route::get('/{userId}/listar', [ProdutoUsuarioController::class, 'listar']);
    });



         /**
     * Rotas de entreas
     * Gerenciamento de entregas de remessas (CRUD)
     *
     * @prefix enderecos
     * @middleware permission
     */
    Route::prefix('entregas-cliente')->group(function () {
        Route::get('/', [EntregaClienteController::class, 'index']);
        Route::post('/', [EntregaClienteController::class, 'store']);
        Route::get('/{id}', [EntregaClienteController::class, 'show']);
        Route::put('/{id}', [EntregaClienteController::class, 'update']);
        Route::delete('/{id}', [EntregaClienteController::class, 'destroy']);
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

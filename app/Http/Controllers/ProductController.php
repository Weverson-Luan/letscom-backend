<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\JsonResponse;

/**
 * Controller para gerenciamento de Produtos
 * 
 * @package App\Http\Controllers
 * @version 1.0.0
 */
class ProductController extends Controller
{
    /** @var ProductService */
    protected $service;

    /**
     * Construtor do controller
     * 
     * @param ProductService $service Serviço de produtos
     */
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * Lista produtos com paginação
     * 
     * @param Request $request Requisição HTTP
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->service->list($request->all());
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Cria um novo produto
     * 
     * @param ProductRequest $request Requisição validada
     * @return JsonResponse
     */
    public function store(ProductRequest $request): JsonResponse
    {
        try {
            $product = $this->service->create($request->validated());
            return response()->json($product, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Exibe um produto específico
     * 
     * @param Product $product Produto a ser exibido
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    /**
     * Atualiza um produto
     * 
     * @param ProductRequest $request Requisição validada
     * @param Product $product Produto a ser atualizado
     * @return JsonResponse
     */
    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        try {
            $success = $this->service->update($product, $request->validated());
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove um produto
     * 
     * @param Product $product Produto a ser removido
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            $success = $this->service->delete($product);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
} 
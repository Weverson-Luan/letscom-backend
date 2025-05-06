<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\JsonResponse;

/**
 * Controller para gerenciamento de Clientes
 *
 * @package App\Http\Controllers
 * @version 1.0.0
 */
class ClientController extends Controller
{
    /** @var ClientService */
    protected $service;

    public function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        try {

            $result = $this->service->list($request->all());
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(ClientRequest $request): JsonResponse
    {
        try {

            $client = $this->service->create($request->validated());
            return response()->json($client, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(ClientRequest $request, Client $client): JsonResponse
{
    try {

        $updated = $this->service->update($client, $request->validated());
        return response()->json($updated);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    public function show(Client $client): JsonResponse
    {
        return response()->json($client);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
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

    public function store(UserRequest $request): JsonResponse
    {
        try {
            $user = $this->service->create($request->validated());
            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(User $user): JsonResponse
    {
        try {
            $user = $this->service->findWithPermissions($user->id);
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        try {
            $success = $this->service->update($user, $request->validated());
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(User $user): JsonResponse
    {
        try {
            $success = $this->service->delete($user);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
} 
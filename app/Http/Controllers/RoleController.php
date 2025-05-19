<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoleService;

class RoleController extends Controller
{
    protected $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->listRoles());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name',
            'description' => 'nullable|string'
        ]);

        return response()->json($this->service->createRole($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'description' => 'nullable|string'
        ]);

        return response()->json($this->service->updateRole($id, $data));
    }

    public function destroy($id)
    {
        $this->service->deleteRole($id);
        return response()->json(['message' => 'Role deletada com sucesso.']);
    }
}

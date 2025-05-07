<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RemessaFotoService;

class RemessaFotoController extends Controller
{
    protected $service;

    public function __construct(RemessaFotoService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request, $remessaId)
    {
        $request->validate([
            'zip_file' => 'required|file|mimes:zip',
            'cliente_id' => 'required|exists:clients,id'
        ]);

        $result = $this->service->processZip($request->file('zip_file'), $remessaId, $request->cliente_id);

        return response()->json([
            'code' => 200,
            'message' => 'Fotos extraídas e salvas com sucesso.',
            'files' => $result
        ]);


    }
}

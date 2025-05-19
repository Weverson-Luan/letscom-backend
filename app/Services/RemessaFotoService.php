<?php
namespace App\Services;

use App\Repositories\RemessaFotoRepository;

class RemessaFotoService
{
    protected $repository;

    public function __construct(RemessaFotoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function processZip($zipFile, $remessaId, $clienteId)
    {
        $zip = new \ZipArchive;
        $filePath = $zipFile->getRealPath();
        $destination = storage_path("app/remessas/fotos/{$remessaId}");

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        if ($zip->open($filePath) === TRUE) {
            $zip->extractTo($destination);
            $zip->close();

            $saved = [];

            foreach (scandir($destination) as $file) {
                if (in_array($file, ['.', '..'])) continue;

                $relativePath = "remessas/fotos/{$remessaId}/{$file}";

                $this->repository->create([
                    'remessa_id' => $remessaId,
                    'cliente_id' => $clienteId,
                    'file_path' => $relativePath,
                ]);

                $saved[] = $relativePath;
            }

            return $saved;
        }

        throw new \Exception("Erro ao extrair o zip.");
    }
}

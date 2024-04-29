<?php

namespace App\Http\Service\Traits;

use Illuminate\Support\Str;


trait FileDownloadTrait
{
    public function downloadImage(string $imageUrl, string $dir = 'uploads'): ?string
    {
        // Obtém o conteúdo da imagem do link fornecido
        $imageData = file_get_contents($imageUrl);

        // Verifica se o conteudo da imagem foi bem sucedido
        if ($imageData === false) {
            return null; // Retorna null se não foi possível obter o conteúdo da imagem
        }

        // Gera um nome aleatório para a imagem com a extensão .jpg
        $fileName = Str::random(30) . '.jpg';

        // Salva a imagem no diretório especificado
        $saved = file_put_contents(public_path($dir . '/' . $fileName), $imageData);

        if (!$saved) {
            return null; // Retorna null se não foi possível salvar a imagem
        }

        return $dir . '/' . $fileName; // Retorna o caminho da imagem salva
    }
}

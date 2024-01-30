<?php

namespace App\Traits;

use Illuminate\Http\Request;
use File;
use Illuminate\Support\Str;


trait FileUploadTrait
{
    public function handleFileUpload(Request $request, string $fieldName, ?string $oldPath = null, string $dir = 'uploads'): ?string
    {
        /** Checando se existe um arquivo no request */
        if (!$request->hasFile($fieldName)) {
            return null;
        }

        /** Deleta a imagem existente */
        if ($oldPath && File::exists(public_path($oldPath))) {
            File::delete(public_path($oldPath));
        }

        /** movendo a imagem do request, pra um diretorio publico */
        $file = $request->file($fieldName);
        $extension = $file->getClientOriginalExtension();
        $updatedfileName = Str::random(30) . '.' . $extension;

        $file->move(public_path($dir), $updatedfileName);

        return $dir . '/' . $updatedfileName;
    }

    public function deleteFile(string $path): void
    {
        /** Deleta a imagem existente */
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}

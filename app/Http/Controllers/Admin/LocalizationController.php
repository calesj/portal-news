<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class LocalizationController extends Controller
{
    public function adminIndex(): View
    {
        $languages = Language::all();
        return view('admin.localization.admin-index', compact('languages'));
    }

    public function frontendIndex(): View
    {
        $languages = Language::all();
        return view('admin.localization.frontend-index', compact('languages'));
    }

    public function extractLocalizationStrings(Request $request)
    {
        $directory = $request->directory;
        $languageCode = $request->language_code;
        $file_name = $request->file_name;

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

        $localizationString = [];

        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }
            $contents = file_get_contents($file->getPathName());

            preg_match_all('/__\([\'"](.+?)[\'"]\)/', $contents, $matches);

            if (!empty($matches[1])) {
                foreach ($matches[1] as $match) {
                    $localizationString[$match] = $match;
                }
            }
        }

        $phpArray = "<?php\n\nreturn " . var_export($localizationString, true) . ";\n";

        // create language sub folder if it is no exist
        if (!File::isDirectory(lang_path($languageCode))) {
            File::makeDirectory(lang_path($languageCode), 0755, true);
        }

        file_put_contents(lang_path($languageCode . '/' . $file_name . '.php'), $phpArray);
    }

    public function updateLangString(Request $request): RedirectResponse
    {
        $languageStrings = trans($request->file_name, [], $request->lang_code);

        $languageStrings[$request->key] = $request->value;

        $phpArray = "<?php\n\nreturn " . var_export($languageStrings, true) . ";\n";

        file_put_contents(lang_path($request->lang_code . '/' . $request->file_name . '.php'), $phpArray);

        toast(__('Updated Successfully.'), 'success');

        return redirect()->back();
    }
}

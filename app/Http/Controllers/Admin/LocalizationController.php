<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
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
        $directories = explode(',', $request->directory);

        $languageCode = $request->language_code;
        $file_name = $request->file_name;

        $localizationString = [];

        foreach ($directories as $directory) {
            $directory = trim($directory);
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

            foreach ($files as $file) {
                if ($file->isDir()) {
                    continue;
                }
                $contents = file_get_contents($file->getPathName());

                preg_match_all('/__\([\'"](.+?)[\'"]\)/', $contents, $matches);

                if (!empty($matches[1])) {
                    foreach ($matches[1] as $match) {
                        $match = preg_replace('/^(frontend|admin)\./', '', $match);
                        $localizationString[$match] = $match;
                    }
                }
            }
        }

        $phpArray = "<?php\n\nreturn " . var_export($localizationString, true) . ";\n";

        // create language sub folder if it is no exist
        if (!File::isDirectory(lang_path($languageCode))) {
            File::makeDirectory(lang_path($languageCode), 0755, true);
        }

        file_put_contents(lang_path($languageCode . '/' . $file_name . '.php'), $phpArray);

        toast(__('admin.Generated Successfully!'), 'success');

        return redirect()->back();
    }

    public function updateLangString(Request $request): RedirectResponse
    {
        $languageStrings = trans($request->file_name, [], $request->lang_code);

        $languageStrings[$request->key] = $request->value;

        $phpArray = "<?php\n\nreturn " . var_export($languageStrings, true) . ";\n";

        file_put_contents(lang_path($request->lang_code . '/' . $request->file_name . '.php'), $phpArray);

        toast(__('admin.Updated Successfully.'), 'success');

        return redirect()->back();
    }

    public function updateAdminLangString(Request $request): RedirectResponse
    {
        $languageStrings = trans($request->file_name, [], $request->lang_code);

        $languageStrings[$request->key] = $request->value;

        $phpArray = "<?php\n\nreturn " . var_export($languageStrings, true) . ";\n";

        file_put_contents(lang_path($request->lang_code . '/' . $request->file_name . '.php'), $phpArray);

        toast(__('admin.Updated Successfully.'), 'success');

        return redirect()->back();
    }

    public function translateString(Request $request)
    {
        $langCode = $request->language_code;

        $languageStrings = trans($request->file_name, [], $langCode);

        $keyStrings = array_keys($languageStrings);

        // ['home', 'about']
        // homeabout
        $text = implode(' || ', $keyStrings);

        $response = Http::withHeaders([
            'X-RapidAPI-Host' => 'microsoft-translator-text.p.rapidapi.com',
            'X-RapidAPI-Key' => '7d4ef1bfc9msh5e2527c24e30411p1e6c50jsnfe4891f84ec7',
            'content-type' => 'application/json',
        ])->post("https://microsoft-translator-text.p.rapidapi.com/translate?api-version=3.0&to%5B0%5D=$langCode&textType=plain&profanityAction=NoAction", [
            [
                'Text' => $text
            ]
        ]);

        $translatedText = json_decode($response->body())[0]->translations[0]->text;
        $translatedValues = explode(' || ', $translatedText);

        $updatedArray = array_combine($keyStrings, $translatedValues);

        $phpArray = "<?php\n\nreturn " . var_export($updatedArray, true) . ";\n";

        file_put_contents(lang_path($langCode . '/' . $request->file_name . '.php'), $phpArray);

        return response()->json(['status' => 'success', 'message' => __('admin.Translation is completed.')]);
    }
}

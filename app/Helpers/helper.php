<?php

use App\Models\Language;


/** format news tags */
function formatTags(array $tags): string
{
    return implode(',', $tags);
}

/**
 * get selected languages from session
 */
function getLanguage(): string
{
    if (session()->has('language')) {
        return session('language');
    }

    try {
        $language = Language::where('default', 1)->first();
        setLanguage($language->lang);

        return $language->lang;
    } catch (Throwable $th) {
        setLanguage('pt');
        return $language->lang;
    }
}

/** set language code in session */
function setLanguage(string $code): void
{
    session(['language' => $code]);
}

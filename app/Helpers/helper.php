<?php

use App\Models\Language;
use Illuminate\Support\Str;


/** format news tags */
function formatTags(array $tags): string
{
    return implode(',', $tags);
}

/**
 * get selected languages from session
 */
function getLanguage()
{
    if (session()->has('language')) {
        return session('language');
    }

    $language = Language::where('default', 1)->first();

    if ($language) {
        setLanguage($language->lang);

        return session('language');
    }

    setLanguage('pt');

    return session('language');
}

/** set language code in session */
function setLanguage(string $code): void
{
    session(['language' => $code]);
}

/** This is a title */
/** Truncante text */
function truncateStr(string $text, int $limit = 50): string
{
    return Str::limit($text, $limit, '...');
}

/** Format a number in K format */
function convertToKFormat(int $number): string
{
    if ($number < 1000) {
        return $number;
    }

    if ($number < 1000000) {
        return round($number / 1000, 1) . 'K'; // 2500 => 2.5K
    }

    return round($number / 1000000, 1)  . 'M'; // 2500000 => 2.5M
}

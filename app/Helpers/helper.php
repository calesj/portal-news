<?php

use App\Models\Language;
use App\Models\Setting;
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

    return round($number / 1000000, 1) . 'M'; // 2500000 => 2.5M
}

/** Make Sidebar Active */
function setSidebarActive(array $routes): ?string
{
    foreach ($routes as $route) {
        if (request()->routeIs($route)) {
            return 'active';
        }
    }

    return '';
}

/** get Seting */
function getSetting($key)
{
    $data = Setting::query()->where('key', $key)->first();

    return $data->value;
}

/** check permission */
function canAccess(mixed $permissions): bool
{
    $permission = auth()->guard('admin')->user()->hasAnyPermission($permissions);
    $superAdmin = auth()->guard('admin')->user()->hasRole('super admin');

    if ($permission || $superAdmin) {
        return true;
    }

    return false;
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;

class NewsController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return view('admin.news.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.news.create');
    }
}

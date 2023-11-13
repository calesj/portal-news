<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return view('admin.news.index', compact('languages'));
    }
}

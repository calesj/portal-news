<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterInfo;
use App\Models\Language;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class FooterInfoController extends Controller
{
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware(['permission:footer index,admin'])->only(['index']);
        $this->middleware(['permission:footer create,admin'])->only(['store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::all();
        return view('admin.footer-info.index', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'description' => ['required', 'string', 'max:300'],
            'copyright' => ['required', 'string', 'max:255'],
        ]);

        $footerInfo = FooterInfo::where('language', $request->language)->first();
        $imagePath = $this->handleFileUpload($request, 'logo', !empty($footerInfo->logo) ? $footerInfo->logo : '');

        FooterInfo::updateOrCreate(
            ['language' => $request->language],
            [
                'logo' => !empty($imagePath) ? $imagePath : $footerInfo->logo,
                'description' => $request->description,
                'copyright' => $request->copyright,
            ]);

        toast(__('Updated Successfully'), 'success');

        return redirect()->back();
    }
}

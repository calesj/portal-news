<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FooterGridTwoSaveRequest;
use App\Models\FooterGridThree;
use App\Models\FooterTitle;
use App\Models\Language;
use Illuminate\Http\Request;

class FooterGridThreeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:footer index,admin'])->only(['index']);
        $this->middleware(['permission:footer create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:footer update,admin'])->only(['edit', 'update', 'handleTitle']);
        $this->middleware(['permission:footer delete,admin'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::all();
        return view('admin.footer-grid-three.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.footer-grid-three.create', compact('languages'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FooterGridTwoSaveRequest $request)
    {
        $footer = new FooterGridThree();
        $footer->language = $request->language;
        $footer->name = $request->name;
        $footer->url = $request->url;
        $footer->status = $request->status;
        $footer->save();

        toast(__('admin.Created Successfully'), 'success');

        return redirect()->route('admin.footer-grid-three.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $footer = FooterGridThree::findOrFail($id);
        $languages = Language::all();
        return view('admin.footer-grid-three.edit', compact('footer','languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FooterGridTwoSaveRequest $request, string $id)
    {
        $footer = FooterGridThree::findOrFail($id);
        $footer->language = $request->language;
        $footer->name = $request->name;
        $footer->url = $request->url;
        $footer->status = $request->status;
        $footer->save();

        toast(__('admin.Updated Successfully'), 'success');

        return redirect()->route('admin.footer-grid-three.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        FooterGridThree::findOrFail($id)->delete();

        return response(['status' => 'success', 'message' => __('admin.Deleted Successfully')]);
    }

    /**
     * Add or update title in grid two footer
     */
    public function handleTitle(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
        ]);

        FooterTitle::updateOrCreate(
            [
                'key' => 'grid_three_title',
                'language' => $request->language,
            ],
            ['value' => $request->title]
        );

        toast(__('admin.Updated Successfully'), 'success');

        return redirect()->route('admin.footer-grid-three.index');
    }
}

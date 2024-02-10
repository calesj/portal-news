<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCategoryCreateRequest;
use App\Http\Requests\AdminCategoryUpdateRequest;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::all();
        return view('admin.category.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.category.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminCategoryCreateRequest $request): RedirectResponse
    {
        $category = new Category();
        $category->language = $request->language;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->show_at_nav = $request->show_at_nav;
        $category->status = $request->status;
        $category->save();

        toast(__('Created Successfully'), 'success')->width(400);
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $languages = Language::all();
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('languages', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminCategoryUpdateRequest $request, string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        $category->language = $request->language;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->show_at_nav = $request->show_at_nav;
        $category->status = $request->status;
        $category->save();

        toast(__('Update Successfully'), 'success')->width(400);
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response(['status' => 'success', 'message' => __('Deleted Successfully')]);
        } catch (\Throwable $e) {
            return response(['status' => 'error', 'message' => __('Something went wrong!')]);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSocialCountStoreRequest;
use App\Http\Requests\AdminSocialCountUpdateRequest;
use App\Models\Language;
use App\Models\SocialCount;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class SocialCountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:social count index,admin'])->only(['index']);
        $this->middleware(['permission:social count create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:social count update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:social count delete,admin'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $languages = Language::all();
        return view('admin.social-count.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $languages = Language::all();
        return view('admin.social-count.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminSocialCountStoreRequest $request): RedirectResponse
    {
        $socialCount = new SocialCount();
        $socialCount->language = $request->language;
        $socialCount->icon = $request->icon;
        $socialCount->url = $request->url;
        $socialCount->fan_count = $request->fan_count;
        $socialCount->fan_type = $request->fan_type;
        $socialCount->button_text = $request->button_text;
        $socialCount->color = $request->color;
        $socialCount->status = $request->status;
        $socialCount->save();

        toast(__('admin.Created Successfully!'), 'success');

        return redirect()->route('admin.social-count.index');
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
        $socialCount = SocialCount::findOrFail($id);
        return view('admin.social-count.edit', compact('languages', 'socialCount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminSocialCountUpdateRequest $request, string $id): RedirectResponse
    {
        $socialCount = SocialCount::findOrFail($id);
        $socialCount->language = $request->language;
        $socialCount->icon = $request->icon;
        $socialCount->url = $request->url;
        $socialCount->fan_count = $request->fan_count;
        $socialCount->fan_type = $request->fan_type;
        $socialCount->button_text = $request->button_text;
        $socialCount->color = $request->color;
        $socialCount->status = $request->status;
        $socialCount->save();

        toast(__('admin.Updated Successfully!'), 'success');

        return redirect()->route('admin.social-count.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $socialCount = SocialCount::findOrFail($id);
        $socialCount->delete();

        return response(['status' => 'success', 'message' => __('admin.Deleted Successfully!')]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminHomeSectionSettingUpdateRequest;
use App\Models\HomeSectionSetting;
use App\Models\Language;
use Illuminate\View\View;

class HomeSectionSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:home section index,admin'])->only(['index']);
        $this->middleware(['permission:home section update,admin'])->only(['update']);
    }
    public function index(): View
    {
        $languages = Language::all();
        return view('admin.home-section-setting.index', compact('languages'));
    }

    public function update(AdminHomeSectionSettingUpdateRequest $request)
    {
        HomeSectionSetting::updateOrCreate(
            ['language' => $request->language], //pt
            [
                'category_section_one' => $request->category_section_one,
                'category_section_two' => $request->category_section_two,
                'category_section_three' => $request->category_section_three,
                'category_section_four' => $request->category_section_four,
            ]
        );

        toast(__('admin.Updated successfully!'), 'success');
        return redirect()->back();
    }
}

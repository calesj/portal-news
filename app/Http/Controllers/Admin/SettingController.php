<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminGeneralSettingUpdateRequest;
use App\Http\Requests\AdminSeoSettingUpdateRequest;
use App\Models\Setting;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware(['permission:setting index,admin'])->only(['index']);
        $this->middleware(['permission:setting update,admin'])->only(['updateAppearenceSetting', 'updateGeneralSetting', 'updateSeoSetting']);
    }

    public function index()
    {
        return view('admin.setting.index');
    }

    public function updateGeneralSetting(AdminGeneralSettingUpdateRequest $request): RedirectResponse
    {
        $logoPath = $this->handleFileUpload($request, 'site_logo');
        $faviconPath = $this->handleFileUpload($request, 'site_favicon');

        Setting::query()->updateOrCreate(
            ['key' => 'site_name'],
            ['value' => $request->site_name]
        );

        if (!empty($logoPath)) {
            Setting::query()->updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => $logoPath]
            );
        }

        if (!empty($faviconPath)) {
            Setting::query()->updateOrCreate(
                ['key' => 'site_favicon'],
                ['value' => $faviconPath]
            );
        }

        toast(__('admin.Updated Successfully!'), 'success');

        return redirect()->back();
    }

    public function updateSeoSetting(AdminSeoSettingUpdateRequest $request): RedirectResponse
    {
        Setting::query()->updateOrCreate(
            ['key' => 'site_seo_title'],
            ['value' => $request->site_seo_title]
        );

        Setting::query()->updateOrCreate(
            ['key' => 'site_seo_description'],
            ['value' => $request->site_seo_description]
        );

        Setting::query()->updateOrCreate(
            ['key' => 'site_seo_keywords'],
            ['value' => $request->site_seo_keywords]
        );

        toast(__('admin.Updated Successfully!'), 'success');

        return redirect()->back();
    }

    public function updateAppearenceSetting(Request $request): RedirectResponse
    {
        $request->validate([
            'site_color' => ['required', 'max:200']
        ]);

        Setting::query()->updateOrCreate(
            ['key' => 'site_color'],
            ['value' => $request->site_color]
        );

        toast(__('admin.Updated Successfully!'), 'success');

        return redirect()->back();
    }

    public function updateMicrosoftApiSetting(Request $request) : RedirectResponse
    {
        $request->validate([
            'site_microsoft_api_host' => 'required',
            'site_microsoft_api_key' => 'required',
        ]);

        Setting::updateOrCreate(
          ['key' => 'site_microsoft_api_host'],
          ['value' => $request->site_microsoft_api_host]
        );

        Setting::updateOrCreate(
            ['key' => 'site_microsoft_api_key'],
            ['value' => $request->site_microsoft_api_key]
        );

        toast(__('admin.Updated Successfully!'), 'success');

        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use App\Models\SocialLink;
use App\Models\Subscriber;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $publishedNews = News::where(['status' => 1, 'is_approved' => 1])->count();
        $pendingNews = News::where(['status' => 1, 'is_approved' => 0])->count();
        $categories = Category::count();
        $languages = Language::count();
        $roles = Role::count();
        $permissions = Permission::count();
        $socials = SocialLink::count();
        $subscribers = Subscriber::count();

        return view('admin.dashboard.index', compact([
            'publishedNews',
            'pendingNews',
            'categories',
            'languages',
            'roles',
            'permissions',
            'socials',
            'subscribers',
        ]));
    }
}

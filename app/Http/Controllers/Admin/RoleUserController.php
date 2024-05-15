<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRoleUserStoreRequest;
use App\Http\Requests\AdminRoleUserUpdateRequest;
use App\Mail\RoleUserCreateMail;
use App\Models\Admin;
use Illuminate\View\View;
use Mail;
use Spatie\Permission\Models\Role;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $admins = Admin::all();
        return view('admin.role-user.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Role::all();
        return view('admin.role-user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRoleUserStoreRequest $request)
    {
        try {
            $user = new Admin();
            $user->image = '';
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->status = 1;
            $user->save();

            /** Vinculado cargo ao usuario */
            $user->assignRole($request->role);

            /** Enviando e-mail para o usuario */
            Mail::to($request->email)->send(new RoleUserCreateMail($request->email, $request->password));

            toast(__('admin.Created successfully'), 'success');

        } catch (\Throwable $th) {
            toast(__($th->getMessage()), 'success');
        }

        return redirect()->route('admin.role-users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $user = Admin::findOrFail($id);
        $roles = Role::all();
        return view('admin.role-user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRoleUserUpdateRequest $request, string $id)
    {
        if ($request->has('password') && !empty($request->password)) {
            $request->validate([
                'password' => ['required', 'min:6', 'confirmed'],
            ]);
        }

        $user = Admin::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('password') && !empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        /** Vinculado cargo ao usuario */
        $user->syncRoles($request->role);

        toast(__('admin.Updated successfully'), 'success');

        return redirect()->route('admin.role-users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->getRoleNames()->first() === 'super admin') {
            return response()->json(['status' => 'error', 'message' => __('admin.Can\'t delete the super admin')]);
        }

        return response()->json(['status' => 'success', 'message' => __('admin.Deleted successfully')]);
    }
}

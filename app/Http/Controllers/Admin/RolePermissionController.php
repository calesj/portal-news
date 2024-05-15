<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:access management index,admin'])->only(['index']);
        $this->middleware(['permission:access management create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:access management update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:access management delete,admin'])->only(['destroy']);
    }

    /**
     * View index das permissoes
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * View create das permissoes
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy('group_name');

        return view('admin.role.create', compact('permissions'));
    }

    /**
     * View create das role
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required', 'max:50', 'unique:permissions,name',
        ]);

        /** Criando Rule */
        $role = Role::create(['guard_name' => 'admin', 'name' => $request->role]);

        /** Vinculado as permissões a nova rule */
        $role->syncPermissions($request->permissions);

        toast(__('admin.Created Successfully'), 'success');

        return redirect()->back();
    }

    /**
     * View edit das role
     */
    public function edit(string $id): View
    {
        $permissions = Permission::all()->groupBy('group_name');
        $role = Role::findOrFail($id);
        $rolesPermissions = $role->permissions;
        $rolesPermissions = $rolesPermissions->pluck('name')->toArray();
        return view('admin.role.edit', compact('role', 'permissions', 'rolesPermissions'));
    }

    /**
     * Atualiza alguma role
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'role' => 'required', 'max:50', 'unique:permissions,name',
        ]);

        $role = Role::findOrFail($id);
        $role->update(['guard_name' => 'admin', 'name' => $request->role]);
        $role->syncPermissions($request->permissions);

        toast(__('admin.Updated Successfully'), 'success');

        return redirect()->back();
    }

    /**
     * Deleta a role
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'Super Admin') {
            return response()->json(['status' => 'error', 'message' => __('admin.Can\'t Delete the Super Admin')]);
        }

        $role->delete();

        return response()->json(['status' => 'success', 'message' => __('admin.Deleted Successfully')]);
    }
}

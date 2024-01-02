<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPasswordUpdateRequest;
use App\Http\Requests\AdminProfileUpdateRequest;
use App\Models\Admin;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
Use Alert;

class ProfileController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = Auth::guard('admin')->user();
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminProfileUpdateRequest $request, string $id): RedirectResponse
    {
        $user = Admin::findOrFail($id);
        $oldImagePath = null;

        /** Se existir uma imagem no request, ele vai mover pra um diretorio publico, e retornar o caminho da imagem */
        $imagePath = $this->handleFileUpload($request, 'image', $oldImagePath);

        /**
         * Atualizando as informaçoes do usuario
         */
        $user->image = !empty($imagePath) ? $imagePath : $oldImagePath;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        toast(__('Profile has been updated successfully'), __('success'))->width('400');

        return redirect()->back();
    }

    /**
     * Atualizando a senha do usuario
     */
    public function passwordUpdate(AdminPasswordUpdateRequest $request, string $id): RedirectResponse
    {
        $admin = Admin::findOrFail($id);
        $admin->password = bcrypt($request->password);
        $admin->save();

        toast(__('Updated successfully'), __('success'))->width('400');

        return redirect()->back();
    }
}

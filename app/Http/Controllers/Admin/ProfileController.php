<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminProfileUpdateRequest;
use App\Models\Admin;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('admin')->user();

        return view('admin.profile.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminProfileUpdateRequest $request, string $id)
    {
        $user = Admin::findOrFail($id);
        $oldImagePath = null;

        if ($user->image) {
            $oldImagePath = $user->image;
        }

        /** Se existir uma imagem no request, ele vai mover pra um diretorio publico, e retornar o caminho da imagem */
        $imagePath = $this->handleFileUpload($request, 'image', $oldImagePath);

        /**
         * Atualizando as informaçoes do usuario
         */
        $user->image = !empty($imagePath) ? $imagePath : $oldImagePath;
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

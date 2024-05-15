<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminResetPasswordRequest;
use App\Http\Requests\HandleLoginRequest;
use App\Http\Requests\SendResetLinkRequest;
use App\Mail\AdminSendResetLinkMail;
use App\Models\Admin;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * Mostra a view de login
     * @return View|RedirectResponse
     */
    public function login(): View | RedirectResponse
    {
        if (\auth('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Método que faz a autenticação
     * @throws ValidationException
     */
    public function handleLogin(HandleLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        return redirect()->route('admin.dashboard');
    }

    /** faz o logout da sessão */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login.get');
    }

    /** renderiza a view de redefinição de senha */
    public function forgotPassword(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * gera um token de autenticação, armazena no banco de dados, e envia um link de redefinição de senha com esse token
     * no email do usuario
     * */
    public function sendResetLink(SendResetLinkRequest $request): RedirectResponse
    {
        $token = Str::random(64);

        $admin = Admin::where('email', $request->email)->first();
        $admin->remember_token = $token;
        $admin->save();

        /** enviando o token, e o email como parametro, para podermos utiliza-los na view de e-mail */
        Mail::to($request->email)->send(new AdminSendResetLinkMail($token, $admin->email));

        return redirect()->back()->with('success', __('admin.A mail has been sent to your email address. Please check'));
    }

    /** renderiza a view de alteração de senha */
    public function resetPassword($token): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('admin.auth.reset-password', compact('token'));
    }

    /**
     * verifica se o token contido no link de redefinição é o mesmo vinculado ao e-mail no banco de dados
     * se for, ele faz a redefinição de senha, caso contrário, retornará um erro de token invalido ou expirado
     */
    public function handleResetPassword(AdminResetPasswordRequest $request): RedirectResponse
    {
        $admin = Admin::where(['email' => $request->email, 'remember_token' => $request->token])->first();

        if (!$admin) {
            return back()->with('error', __('admin.Token invalid or expirated'));
        }

        $admin->password = bcrypt($request->password);
        $admin->remember_token = null;

        $admin->save();

        return redirect()->route('admin.login.get')->with('success', __('admin.successfull reset password'));
    }
}


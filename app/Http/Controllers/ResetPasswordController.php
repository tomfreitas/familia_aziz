<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request)
    {
        $token = $request->token;
        $email = $request->email;
        return view('auth.passwords.reset', compact('token','email'));
    }


    public function reset(Request $request)
    {
        // Lógica de validação dos dados do formulário
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if($status){
             return redirect()->route('login.index')->with('success', 'Senha alterada com sucesso');
        } else{
             return redirect()->back()->with('error', 'Não foi possível alterar a senha');
        }
    }
}


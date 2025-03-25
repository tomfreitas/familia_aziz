<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;


class EsqueciSenhaController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }
    //



    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }




    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = DB::table('users')
                ->where('email', $request->email)
                ->first();

        if($email){
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if($status){
                return redirect()->back()->with('success', 'E-mail enviado!<br>Por favor conferir a sua caixa de entrada');
            } else{
                return redirect()->back('login.index')->with('error', 'Não foi possível o e-mail');
            }
        } else {
            return redirect()->back()->with('error', 'O e-mail digitado não está cadastrado no sistema');
        }
    }
}

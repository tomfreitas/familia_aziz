<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login');
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
        try {
            // Validação dos campos obrigatórios
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ], [
                'username.required' => 'O campo usuário é obrigatório',
                'password.required' => 'O campo senha é obrigatório',
            ]);

            // Busca o usuário no banco de dados
            $user = DB::table('users')
                ->where('username', $request->input('username'))
                ->first();

            if (!$user) {
                return redirect()->route('login.index')->withErrors(['error' => 'Usuário incorreto']);
            }

            // Verifica a senha
            if (!password_verify($request->input('password'), $user->password)) {
                return redirect()->route('login.index')->withErrors(['error' => 'Senha incorreta']);
            }

            // Autenticação do usuário
            $credentials = $request->only('username', 'password');
            $authenticated = Auth::attempt($credentials);

            if (!$authenticated) {
                return redirect()->route('login.index')->withErrors(['error' => 'E-mail ou senha incorretos']);
            }

            return redirect()->route('users.index');

        } catch (\Exception $e) {
            // Caso ocorra um erro inesperado
            return redirect()->route('login.index')->withErrors([
                'error' => 'Ocorreu um erro ao tentar fazer login. Tente novamente mais tarde.'
            ]);
        }
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
        Auth::logout();
        return redirect()->route('login.index');
    }
}

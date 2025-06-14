<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'password.required' => 'A senha é obrigatória',
            'password.confirmed' => 'As senhas não conferem',
            'email.unique' => 'O email já está em uso',
            'name.max' => 'O nome deve ter no máximo 255 caracteres',
            'email.max' => 'O email deve ter no máximo 255 caracteres',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres',
            'password.confirmed' => 'As senhas não conferem',
            'email.email' => 'O email deve ser um email válido',
            'name.string' => 'O nome deve ser uma string',
            'email.string' => 'O email deve ser uma string',
            'password.string' => 'A senha deve ser uma string',
        ]);

        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar conta!');
        }

        // Autenticar o usuário
        Auth::login($user);
        $request->session()->regenerate();


        return redirect()->route('dashboard')->with('success', 'Conta criada com sucesso!');
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'O email é obrigatório',
            'password.required' => 'A senha é obrigatória',
            'email.email' => 'O email deve ser um email válido',
            'password.string' => 'A senha deve ser uma string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login realizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Email ou senha inválidos!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Logout realizado com sucesso!');
    }

    public function profile()
    {
        return view('app.profile.index');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'password.confirmed' => 'As senhas não conferem',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres',
            'password.string' => 'A senha deve ser uma string',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        try{
            $user->save();
        } catch (\Exception $e) {
            return redirect()->route('profile')->with('error', 'Erro ao atualizar perfil!');
        }

        return redirect()->route('profile')->with('success', 'Perfil atualizado com sucesso!');
    }
}

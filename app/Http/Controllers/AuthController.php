<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Services\UserService;

class AuthController extends Controller
{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerUser(RegisterRequest $request)
    {
        try{
            $user = $this->userService->createUser($request->name, $request->email, $request->password);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar conta!');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Conta criada com sucesso!');
    }

    public function loginUser(LoginRequest $request)
    {
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

    public function updateProfile(UpdateProfileRequest $request)
    {
        try{
            $user = $this->userService->updateUserProfile(auth()->user()->id, $request->name, $request->email, $request->password);
        } catch (\Exception $e) {
            return redirect()->route('profile')->with('error', 'Erro ao atualizar perfil!');
        }

        return redirect()->route('profile')->with('success', 'Perfil atualizado com sucesso!');
    }
}

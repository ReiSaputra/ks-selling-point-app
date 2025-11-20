<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view("auth.login");
    }

    public function showRegister()
    {
        return view("auth.register");
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route("order-list")->with("success", "Login berhasil");
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required|min:6",
            "password_confirmation" => "required|same:password"
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        return redirect()->route("login")->with("success", "Account created successfully");
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route("login");
    }
}

?>
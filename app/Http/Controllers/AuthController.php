<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    // Menangani proses login
    public function login(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['username' => 'Akun belum terdaftar'])->withInput();
        }

        if (!Auth::attempt($request->only('username', 'password'))) {
            return redirect()->back()->withErrors(['password' => 'Password salah'])->withInput();
        }

        // Jika login berhasil
        return redirect()->route('dashboard');
    }

    // Menangani proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}

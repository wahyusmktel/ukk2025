<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserAuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('user.login');
    }

    /**
     * Menangani proses login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Coba autentikasi pengguna dengan guard 'user'
        if (Auth::guard('user')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            Alert::success('Berhasil', 'Anda berhasil login.');

            return redirect()->route('user.dashboard');
        }

        // Jika gagal login
        Alert::error('Gagal', 'Email atau password salah.');

        return redirect()->back()->withInput($request->only('email'));
    }

    /**
     * Menampilkan halaman dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('user.dashboard');
    }

    /**
     * Menangani logout.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::guard('user')->logout();
        Alert::success('Berhasil', 'Anda berhasil logout.');

        return redirect()->route('user.login');
    }
}

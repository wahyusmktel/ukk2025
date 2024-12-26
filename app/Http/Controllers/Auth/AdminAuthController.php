<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert; // Import SweetAlert

class AdminAuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('login'); // Menampilkan view login
    }

    /**
     * Proses login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba login menggunakan guard admin
        if (Auth::guard('admin')->attempt($request->only('username', 'password'))) {
            $request->session()->regenerate(); // Regenerasi session
            Alert::success('Login Berhasil', 'Selamat datang di dashboard admin!'); // Notifikasi sukses
            return redirect()->intended('/admin/dashboard');
        }

        // Jika login gagal
        Alert::error('Login Gagal', 'Username atau password salah.'); // Notifikasi error
        return back();
    }

    /**
     * Proses logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // Logout dari guard admin
        $request->session()->invalidate(); // Hapus semua session
        $request->session()->regenerateToken(); // Regenerasi token CSRF

        Alert::success('Logout Berhasil', 'Anda telah logout dengan aman.'); // Notifikasi sukses
        return redirect('/login');
    }
}

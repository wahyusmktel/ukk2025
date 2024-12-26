<?php

namespace App\Http\Controllers;

use App\Models\BukuModel;
use Illuminate\Http\Request;

class UserBukuController extends Controller
{
    /**
     * Menampilkan semua data buku beserta relasinya.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua data buku beserta relasi ke kategori
        $buku = BukuModel::with('kategori')->get();

        // Arahkan ke view dan kirim data
        return view('user.buku.index', compact('buku'));
    }
}

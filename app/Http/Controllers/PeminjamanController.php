<?php

namespace App\Http\Controllers;

use App\Models\BukuModel;
use App\Models\PeminjamanModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan semua data peminjaman beserta relasinya.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil data peminjaman beserta relasi ke buku
        $peminjaman = PeminjamanModel::with('buku')->get();

        // Arahkan ke view dan kirim data
        return view('user.peminjaman.index', compact('peminjaman'));
    }

    public function showPeminjaman($bukuId)
    {
        $buku = BukuModel::findOrFail($bukuId);

        return view('user.peminjaman.show', compact('buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'TanggalPeminjaman' => 'required|date',
            'TanggalPengembalian' => 'required|date|after:TanggalPeminjaman',
        ]);

        PeminjamanModel::create([
            'buku_id' => $request->buku_id,
            'TanggalPeminjaman' => $request->TanggalPeminjaman,
            'TanggalPengembalian' => $request->TanggalPengembalian,
            'StatusPeminjaman' => 'Dipinjam',
            'status' => true,
            'created_by' => auth()->guard('user')->id(),
        ]);

        Alert::success('Berhasil', 'Peminjaman buku berhasil disimpan.');

        return redirect()->route('user.buku.index')->with('success', 'Peminjaman berhasil diajukan.');
    }
}

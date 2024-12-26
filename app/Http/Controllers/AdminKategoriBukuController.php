<?php

namespace App\Http\Controllers;

use App\Models\KategoriBukuModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminKategoriBukuController extends Controller
{
    /**
     * Tampilkan semua data kategori buku.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua data dari tabel kategori_buku dengan relasi createdBy dan updatedBy
        $kategoriBuku = KategoriBukuModel::with(['createdBy', 'updatedBy'])->get();

        // Arahkan ke view dan kirim data
        return view('admin.kategori_buku.index', compact('kategoriBuku'));
    }

    // Simpan data baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'NamaKategori' => 'required|string|max:255',
        ]);

        // Simpan data ke database
        KategoriBukuModel::create([
            'NamaKategori' => $request->NamaKategori,
            'status' => true, // Status default true
            'created_by' => auth()->guard('admin')->user()->id, // ID user yang membuat
        ]);

        // Tampilkan notifikasi sukses
        Alert::success('Berhasil', 'Kategori Buku berhasil ditambahkan.');

        // Redirect kembali ke halaman index
        return redirect()->route('admin.kategori_buku.index');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'NamaKategori' => 'required|string|max:255',
        ]);

        // Temukan data berdasarkan ID
        $kategori = KategoriBukuModel::findOrFail($id);

        // Perbarui data
        $kategori->update([
            'NamaKategori' => $request->NamaKategori,
            'updated_by' => auth()->guard('admin')->user()->id, // ID admin yang mengupdate
        ]);

        // Tampilkan notifikasi sukses
        Alert::success('Berhasil', 'Kategori Buku berhasil diperbarui.');

        // Redirect kembali ke halaman index
        return redirect()->route('admin.kategori_buku.index');
    }

    public function destroy($id)
    {
        // Temukan data berdasarkan ID
        $kategori = KategoriBukuModel::findOrFail($id);

        // Hapus data
        $kategori->delete();

        // Tampilkan notifikasi sukses
        Alert::success('Berhasil', 'Kategori Buku berhasil dihapus.');

        // Redirect kembali ke halaman index
        return redirect()->route('admin.kategori_buku.index');
    }
}

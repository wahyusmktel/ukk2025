<?php

namespace App\Http\Controllers;

use App\Models\BukuModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\KategoriBukuModel;

class AdminBukuController extends Controller
{
    /**
     * Menampilkan semua data buku beserta kategorinya.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua data buku beserta kategorinya
        $buku = BukuModel::with('kategori')->get();

        // Ambil data kategori untuk dropdown
        $kategori = KategoriBukuModel::all();

        // Arahkan ke view dan kirim data
        return view('admin.buku.index', compact('buku', 'kategori'));
    }

    /**
     * Simpan data buku baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_buku,id',
            'tahun_terbit' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi file cover
        ]);

        // Proses upload cover jika ada
        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public'); // Simpan di folder storage/app/public/covers
        }

        // Simpan data ke database
        BukuModel::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'kategori_id' => $request->kategori_id,
            'tahun_terbit' => $request->tahun_terbit,
            'cover' => $coverPath, // Simpan path file cover
            'status' => true, // Status default true
            'created_by' => auth()->guard('admin')->user()->id, // ID admin yang membuat
        ]);

        // Tampilkan notifikasi sukses
        Alert::success('Berhasil', 'Buku berhasil ditambahkan.');

        // Redirect kembali ke halaman index
        return redirect()->route('admin.buku.index');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_buku,id',
            'tahun_terbit' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Temukan data berdasarkan ID
        $buku = BukuModel::findOrFail($id);

        // Proses upload cover baru jika ada
        if ($request->hasFile('cover')) {
            // Hapus cover lama jika ada
            if ($buku->cover && file_exists(storage_path('app/public/' . $buku->cover))) {
                unlink(storage_path('app/public/' . $buku->cover));
            }

            // Upload cover baru
            $buku->cover = $request->file('cover')->store('covers', 'public');
        }

        // Update data buku
        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'kategori_id' => $request->kategori_id,
            'tahun_terbit' => $request->tahun_terbit,
            'updated_by' => auth()->guard('admin')->user()->id,
        ]);

        // Tampilkan notifikasi sukses
        Alert::success('Berhasil', 'Buku berhasil diperbarui.');

        // Redirect kembali ke halaman index
        return redirect()->route('admin.buku.index');
    }
}

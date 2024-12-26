@extends('layouts.app')

@section('title', 'Form Peminjaman Buku')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Form Peminjaman Buku</h1>

<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $buku->judul }}</h6>
    </div>
    <div class="card-body">
        @if ($buku->cover)
            <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover" class="img-fluid mb-3">
        @else
            <img src="{{ asset('images/no-cover.png') }}" alt="No Cover" class="img-fluid mb-3">
        @endif
        <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
        <p><strong>Penerbit:</strong> {{ $buku->penerbit }}</p>
        <p><strong>Kategori:</strong> {{ $buku->kategori->NamaKategori ?? 'N/A' }}</p>
        <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
        <form action="{{ route('user.peminjaman.store') }}" method="POST">
            @csrf
            <input type="hidden" name="buku_id" value="{{ $buku->id }}">
            <div class="form-group">
                <label for="TanggalPeminjaman">Tanggal Peminjaman</label>
                <input type="date" name="TanggalPeminjaman" id="TanggalPeminjaman" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="TanggalPengembalian">Tanggal Pengembalian</label>
                <input type="date" name="TanggalPengembalian" id="TanggalPengembalian" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="Durasi">Durasi Peminjaman (Hari)</label>
                <input type="text" id="Durasi" class="form-control" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tanggalPeminjaman = document.getElementById('TanggalPeminjaman');
        const tanggalPengembalian = document.getElementById('TanggalPengembalian');
        const durasi = document.getElementById('Durasi');

        function hitungDurasi() {
            const startDate = new Date(tanggalPeminjaman.value);
            const endDate = new Date(tanggalPengembalian.value);
            const timeDiff = endDate - startDate;
            const daysDiff = timeDiff / (1000 * 3600 * 24);

            durasi.value = isNaN(daysDiff) ? '' : daysDiff + ' hari';
        }

        tanggalPeminjaman.addEventListener('change', hitungDurasi);
        tanggalPengembalian.addEventListener('change', hitungDurasi);
    });
</script>
@endsection

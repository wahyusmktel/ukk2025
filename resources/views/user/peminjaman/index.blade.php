@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Data Peminjaman</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Judul Buku</th>
            <th>Tanggal Peminjaman</th>
            <th>Tanggal Pengembalian</th>
            <th>Status Peminjaman</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($peminjaman as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->buku->judul ?? 'N/A' }}</td>
                <td>{{ $item->TanggalPeminjaman }}</td>
                <td>{{ $item->TanggalPengembalian ?? 'Belum Dikembalikan' }}</td>
                <td>{{ $item->StatusPeminjaman }}</td>
                <td>{{ $item->status ? 'Aktif' : 'Nonaktif' }}</td>
                <td>
                    <!-- Tombol Kembalikan -->
                    <form method="POST" action="{{ route('user.peminjaman.kembalikan', $item->id) }}" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Kembalikan</button>
                    </form>
                    <!-- Tombol Perpanjang -->
                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#perpanjangModal{{ $item->id }}">
                        Perpanjang
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data peminjaman.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

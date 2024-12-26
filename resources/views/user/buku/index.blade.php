@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Daftar Buku</h1>

    <div class="row">
        @forelse ($buku as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <!-- Basic Card -->
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $item->judul }}</h6>
                    </div>
                    <div class="card-body">
                        @if ($item->cover)
                            <img src="{{ asset('storage/' . $item->cover) }}" alt="Cover" class="img-fluid mb-3">
                        @else
                            <img src="{{ asset('images/no-cover.png') }}" alt="No Cover" class="img-fluid mb-3">
                        @endif
                        <p><strong>Penulis:</strong> {{ $item->penulis }}</p>
                        <p><strong>Penerbit:</strong> {{ $item->penerbit }}</p>
                        <p><strong>Kategori:</strong> {{ $item->kategori->NamaKategori ?? 'N/A' }}</p>
                        <p><strong>Tahun Terbit:</strong> {{ $item->tahun_terbit }}</p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('user.peminjaman.show', $item->id) }}" class="btn btn-primary btn-sm">
                            PINJAM
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Tidak ada data buku.
                </div>
            </div>
        @endforelse
    </div>
@endsection

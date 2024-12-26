@extends('layouts.app')

@section('title', 'Kategori Buku')

@section('content')
<div class="container">
    <h1 class="h3 mb-4 text-gray-800">Kategori Buku</h1>

    <!-- Tombol Tambah Data -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahKategoriModal">Tambah Kategori</button>

    <!-- Tabel sederhana untuk menampilkan data -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Status</th>
                <th>Dibuat Oleh</th>
                <th>Diperbarui Oleh</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategoriBuku as $kategori)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kategori->NamaKategori }}</td>
                    <td>{{ $kategori->status ? 'Aktif' : 'Nonaktif' }}</td>
                    <td>{{ $kategori->createdBy->NamaLengkap ?? 'N/A' }}</td>
                    <td>{{ $kategori->updatedBy->NamaLengkap ?? 'N/A' }}</td>
                    <td>
                        <!-- Tombol Edit -->
                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editKategoriModal{{ $kategori->id }}">
                            Edit
                        </button>

                        <!-- Tombol Delete -->
                        <form action="{{ route('admin.kategori_buku.destroy', $kategori->id) }}" method="POST" style="display: inline-block;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $kategori->id }}">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                <!-- Modal Edit -->
                <div class="modal fade" id="editKategoriModal{{ $kategori->id }}" tabindex="-1" aria-labelledby="editKategoriModalLabel{{ $kategori->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('admin.kategori_buku.update', $kategori->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editKategoriModalLabel{{ $kategori->id }}">Edit Kategori Buku</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="NamaKategori">Nama Kategori</label>
                                        <input type="text" class="form-control" id="NamaKategori" name="NamaKategori" value="{{ $kategori->NamaKategori }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data kategori buku.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.kategori_buku.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKategoriModalLabel">Tambah Kategori Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="NamaKategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="NamaKategori" name="NamaKategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // SweetAlert untuk konfirmasi hapus
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                const form = this.closest('form');
                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit form jika user mengonfirmasi
                    }
                });
            });
        });
    });
</script>
@endpush
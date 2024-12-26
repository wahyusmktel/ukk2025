@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')
<div class="container">
    <h1 class="h3 mb-4 text-gray-800">Data Buku</h1>

    <!-- Tombol Tambah Data -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahBukuModal">Tambah Buku</button>

    <!-- Tabel Data Buku -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Kategori</th>
                <th>Tahun Terbit</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($buku as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->penulis }}</td>
                    <td>{{ $item->penerbit }}</td>
                    <td>{{ $item->kategori->NamaKategori ?? 'N/A' }}</td>
                    <td>{{ $item->tahun_terbit }}</td>
                    <td>{{ $item->status ? 'Aktif' : 'Nonaktif' }}</td>
                    <td>
                        <!-- Tombol Edit -->
                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editBukuModal{{ $item->id }}">
                            Edit
                        </button>

                        <!-- Tombol Delete -->
                        <form action="{{ route('admin.buku.destroy', $item->id) }}" method="POST" style="display: inline-block;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $item->id }}">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                <!-- Modal Edit Data -->
                <div class="modal fade" id="editBukuModal{{ $item->id }}" tabindex="-1" aria-labelledby="editBukuModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('admin.buku.update', $item->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editBukuModalLabel{{ $item->id }}">Edit Buku</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input type="text" class="form-control" id="judul" name="judul" value="{{ $item->judul }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="penulis">Penulis</label>
                                        <input type="text" class="form-control" id="penulis" name="penulis" value="{{ $item->penulis }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="penerbit">Penerbit</label>
                                        <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ $item->penerbit }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="kategori_id">Kategori</label>
                                        <select class="form-control" id="kategori_id" name="kategori_id" required>
                                            @foreach ($kategori as $kat)
                                                <option value="{{ $kat->id }}" {{ $kat->id == $item->kategori_id ? 'selected' : '' }}>
                                                    {{ $kat->NamaKategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tahun_terbit">Tahun Terbit</label>
                                        <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ $item->tahun_terbit }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cover">Upload Cover</label>
                                        <input type="file" class="form-control-file" id="cover" name="cover" accept="image/*">
                                        <small class="text-muted">Kosongkan jika tidak ingin mengubah cover.</small>
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
                    <td colspan="7" class="text-center">Tidak ada data buku.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahBukuModal" tabindex="-1" aria-labelledby="tambahBukuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.buku.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahBukuModalLabel">Tambah Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="penulis">Penulis</label>
                        <input type="text" class="form-control" id="penulis" name="penulis" required>
                    </div>
                    <div class="form-group">
                        <label for="penerbit">Penerbit</label>
                        <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori_id">Kategori</label>
                        <select class="form-control" id="kategori_id" name="kategori_id" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->NamaKategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun_terbit">Tahun Terbit</label>
                        <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" required>
                    </div>
                    <div class="form-group">
                        <label for="cover">Upload Cover</label>
                        <input type="file" class="form-control-file" id="cover" name="cover" accept="image/*">
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
<?php

namespace App\Models; // Menentukan namespace model di lokasi App\Models

use Illuminate\Database\Eloquent\Factories\HasFactory; // Mengimpor trait untuk mendukung pembuatan data tiruan (factory)
use Illuminate\Foundation\Auth\User as Authenticatable; // Mengimpor class untuk mendukung autentikasi pengguna
use Illuminate\Database\Eloquent\SoftDeletes; // Mengimpor trait untuk fitur soft delete
use Illuminate\Support\Str; // Mengimpor class Str untuk manipulasi string, termasuk pembuatan UUID

class Admin extends Authenticatable // Membuat class Admin yang mewarisi fungsi autentikasi dari Authenticatable
{
    use HasFactory, SoftDeletes; // Menggunakan trait HasFactory untuk factory dan SoftDeletes untuk soft delete

    /**
     * Menentukan tipe data kunci utama (id) sebagai string
     *
     * @var string
     */

    protected $table = 'admins'; // Secara eksplisit menentukan nama tabel di database

    protected $keyType = 'string';

    /**
     * Menonaktifkan auto-increment untuk primary key
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Daftar kolom yang dapat diisi secara massal
     *
     * @var array
     */
    protected $fillable = [
        'id',            // UUID unik untuk setiap admin
        'username',      // Nama pengguna untuk login
        'password',      // Password untuk autentikasi
        'email',         // Alamat email unik
        'NamaLengkap',   // Nama lengkap admin
        'Alamat',        // Alamat admin
        'Status',        // Status aktif (true/false)
        'created_by',    // ID pengguna yang membuat data
        'updated_by',    // ID pengguna yang memperbarui data
    ];

    /**
     * Daftar atribut yang harus di-cast ke tipe data tertentu
     *
     * @var array
     */
    protected $casts = [
        'Status' => 'boolean', // Mengubah atribut Status menjadi boolean
    ];

    /**
     * Boot method untuk model.
     * Digunakan untuk mengatur event saat model diinisialisasi.
     */
    protected static function boot()
    {
        parent::boot(); // Memanggil fungsi boot dari parent (Authenticatable)

        // Event listener yang dijalankan sebelum data dibuat (creating)
        static::creating(function ($model) {
            if (empty($model->id)) { // Jika kolom id kosong
                $model->id = Str::uuid()->toString(); // Buat UUID baru untuk kolom id
            }
        });
    }
}

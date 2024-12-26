<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PeminjamanModel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'peminjaman';

    /**
     * Kunci utama tipe string.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Nonaktifkan auto-increment untuk primary key.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Daftar kolom yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'buku_id',
        'TanggalPeminjaman',
        'TanggalPengembalian',
        'StatusPeminjaman',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Boot method untuk model.
     */
    protected static function boot()
    {
        parent::boot();

        // Secara otomatis buat UUID untuk id saat membuat data baru
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString();
            }
        });
    }

    /**
     * Relasi ke model BukuModel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buku()
    {
        return $this->belongsTo(BukuModel::class, 'buku_id');
    }
}

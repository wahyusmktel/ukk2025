<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BukuModel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'buku';

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
        'kategori_id',
        'judul',
        'penulis',
        'penerbit',
        'cover',
        'tahun_terbit',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Daftar kolom yang harus di-cast ke tipe data tertentu.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'tahun_terbit' => 'integer',
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
     * Relasi ke model KategoriBukuModel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriBukuModel::class, 'kategori_id');
    }
}

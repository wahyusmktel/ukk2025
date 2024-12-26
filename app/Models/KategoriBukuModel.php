<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class KategoriBukuModel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'kategori_buku';

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
        'NamaKategori',
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

        // Event sebelum data dihapus (soft delete)
        static::deleting(function ($model) {
            $model->deleted_by = auth()->guard('admin')->user()->id ?? null;
            $model->saveQuietly(); // Simpan tanpa memicu event lagi
        });
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'updated_by');
    }
}

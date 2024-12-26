<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel peminjaman.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key menggunakan UUID
            $table->uuid('buku_id'); // Foreign key ke tabel buku
            $table->date('TanggalPeminjaman'); // Tanggal peminjaman
            $table->date('TanggalPengembalian')->nullable(); // Tanggal pengembalian
            $table->string('StatusPeminjaman'); // Status peminjaman (contoh: "Dipinjam", "Dikembalikan")
            $table->boolean('status')->default(true); // Status default true
            $table->uuid('created_by')->nullable(); // ID pembuat data
            $table->uuid('updated_by')->nullable(); // ID pengubah data
            $table->uuid('deleted_by')->nullable(); // ID penghapus data
            $table->timestamps(); // Kolom created_at dan updated_at
            $table->softDeletes(); // Kolom deleted_at untuk soft delete

            // Foreign key constraint
            $table->foreign('buku_id')->references('id')->on('buku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
}

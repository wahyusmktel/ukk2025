<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel buku.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key menggunakan UUID
            $table->uuid('kategori_id'); // Foreign key ke tabel kategori_buku
            $table->string('judul'); // Judul buku
            $table->string('penulis'); // Penulis buku
            $table->string('penerbit'); // Penerbit buku
            $table->string('cover')->nullable(); // Nama file cover buku
            $table->year('tahun_terbit'); // Tahun terbit buku
            $table->boolean('status')->default(true); // Status default true
            $table->uuid('created_by')->nullable(); // ID pembuat data
            $table->uuid('updated_by')->nullable(); // ID pengubah data
            $table->uuid('deleted_by')->nullable(); // ID penghapus data
            $table->timestamps(); // Kolom created_at dan updated_at
            $table->softDeletes(); // Kolom deleted_at untuk soft delete

            // Foreign key constraint
            $table->foreign('kategori_id')->references('id')->on('kategori_buku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buku');
    }
}

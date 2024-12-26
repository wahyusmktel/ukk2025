<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriBukuTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel kategori_buku.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_buku', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key menggunakan UUID
            $table->string('NamaKategori'); // Kolom nama kategori
            $table->boolean('status')->default(true); // Status default bernilai true
            $table->uuid('created_by')->nullable(); // Kolom created_by untuk ID pembuat
            $table->uuid('updated_by')->nullable(); // Kolom updated_by untuk ID pengubah
            $table->uuid('deleted_by')->nullable(); // Kolom deleted_by untuk ID penghapus
            $table->timestamps(); // Kolom created_at dan updated_at
            $table->softDeletes(); // Kolom deleted_at untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kategori_buku');
    }
}

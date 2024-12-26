<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminsTableSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel admins.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'id' => Str::uuid()->toString(), // Membuat UUID unik untuk id
            'username' => 'admin',          // Username untuk login
            'password' => Hash::make('password123'), // Password yang di-hash untuk keamanan
            'email' => 'admin@example.com', // Email unik
            'NamaLengkap' => 'Administrator', // Nama lengkap admin
            'Alamat' => 'Jl. Contoh Alamat, Kota Laravel', // Alamat admin
            'Status' => true,               // Status aktif
            'created_by' => null,           // ID pembuat data (null untuk data awal)
            'updated_by' => null,           // ID pembaruan data (null untuk data awal)
            'created_at' => now(),          // Timestamp untuk waktu pembuatan
            'updated_at' => now(),          // Timestamp untuk waktu pembaruan
        ]);
    }
}

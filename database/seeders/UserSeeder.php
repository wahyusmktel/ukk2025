<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => Str::uuid()->toString(),
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), // Ganti dengan password yang diinginkan
            'remember_token' => Str::random(10),
            'status' => true,
            'created_by' => null, // Untuk data awal bisa dibiarkan null
            'updated_by' => null, // Untuk data awal bisa dibiarkan null
        ]);
    }
}

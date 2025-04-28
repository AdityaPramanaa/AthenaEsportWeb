<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Hapus user admin yang ada jika ada
        User::where('email', 'admin@athena.com')->delete();

        // Buat user admin baru
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@athena.com',
            'password' => Hash::make('admin123'),
            'nim' => '000000001',
            'prodi' => 'Sistem Informasi',
            'angkatan' => '2024',
            'phone' => '081234567890',
            'ktm' => 'admin.jpg',
            'alasan_bergabung' => 'Super Admin Account',
            'role' => 'admin',
            'status' => 'approved',
            'is_verified' => true,
            'email_verified_at' => now()
        ]);
    }
}

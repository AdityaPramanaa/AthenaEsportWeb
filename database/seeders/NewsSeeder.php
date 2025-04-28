<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('email', 'admin@athena.com')->first();

        if ($admin) {
            // Berita 1
            News::create([
                'title' => 'Welcome to UKM Athena',
                'content' => 'Selamat datang di UKM Athena E-Sport. Kami adalah organisasi mahasiswa yang berdedikasi untuk mengembangkan bakat esports.',
                'type' => 'announcement',
                'status' => 'published',
                'created_by' => $admin->id,
            ]);

            // Berita 2
            News::create([
                'title' => 'Tournament MLBB Season 12',
                'content' => 'Bersiaplah untuk tournament MLBB terbesar tahun ini! Total hadiah mencapai jutaan rupiah. Pendaftaran akan segera dibuka.',
                'type' => 'news',
                'status' => 'published',
                'created_by' => $admin->id,
            ]);

            // Berita 3
            News::create([
                'title' => 'Workshop Game Development',
                'content' => 'Ingin belajar membuat game? Ikuti workshop game development bersama para profesional industri game.',
                'type' => 'news',
                'status' => 'published',
                'created_by' => $admin->id,
            ]);

            // Berita 4
            News::create([
                'title' => 'Tips Menjadi Pro Player',
                'content' => 'Pelajari rahasia sukses para pro player dalam meningkatkan skill bermain game. Dari pengaturan perangkat hingga strategi bermain.',
                'type' => 'news',
                'status' => 'published',
                'created_by' => $admin->id,
            ]);
        }
    }
} 
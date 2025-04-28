<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\News;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            AdminUserSeeder::class,
            GameSeeder::class,
        ]);

        // Get admin user
        $admin = User::where('email', 'admin@athena.com')->first();

        // Create some news
        News::create([
            'title' => 'Welcome to UKM Athena',
            'content' => 'Welcome to UKM Athena E-Sport. We are a student organization dedicated to developing e-sports talent.',
            'type' => 'news',
            'status' => 'published',
            'created_by' => $admin->id,
        ]);

        News::create([
            'title' => 'Upcoming Tournament',
            'content' => 'Get ready for our upcoming tournament! More details will be announced soon.',
            'type' => 'announcement',
            'status' => 'published',
            'created_by' => $admin->id,
        ]);

        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'nim' => 'admin',
            'prodi' => 'Admin',
            'angkatan' => 2024,
            'phone' => '08123456789',
            'alasan_bergabung' => 'Admin Account',
            'role' => 'admin',
            'status' => 'approved',
            'email_verified_at' => now(),
            'is_verified' => true
        ]);
    }
}

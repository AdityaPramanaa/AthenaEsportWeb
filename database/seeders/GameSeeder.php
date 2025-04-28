<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GameSeeder extends Seeder
{
    public function run()
    {
        $games = [
            [
                'name' => 'Mobile Legends',
                'description' => 'Mobile Legends adalah game MOBA 5v5 yang populer di Indonesia. Bergabunglah dengan tim kami dan tunjukkan skill MOBA terbaikmu!',
                'image' => 'images/games/ml.jpg',
                'slug' => 'mobile-legends',
                'status' => 'active'
            ],
            [
                'name' => 'PUBG Mobile',
                'description' => 'PUBG Mobile adalah game battle royale yang menantang. Bersiaplah untuk bertahan hidup dan menjadi juara dalam pertempuran!',
                'image' => 'images/games/pubg.jpg',
                'slug' => 'pubg-mobile',
                'status' => 'active'
            ],
            [
                'name' => 'Valorant',
                'description' => 'Valorant adalah tactical shooter dengan karakter unik. Bergabunglah dengan tim kami dan kuasai strategi pertempuran!',
                'image' => 'images/games/valorant.jpg',
                'slug' => 'valorant',
                'status' => 'active'
            ],
            [
                'name' => 'Free Fire',
                'description' => 'Free Fire adalah game battle royale yang seru. Tunjukkan skill survival terbaikmu dan raih kemenangan!',
                'image' => 'images/games/ff.jpg',
                'slug' => 'free-fire',
                'status' => 'active'
            ],
            [
                'name' => 'Tekken',
                'description' => 'Tekken adalah game fighting yang legendaris. Kuasai teknik pertarungan dan jadilah juara dalam pertarungan satu lawan satu!',
                'image' => 'images/games/tekken.jpg',
                'slug' => 'tekken',
                'status' => 'active'
            ],
            [
                'name' => 'Dota 2',
                'description' => 'Dota 2 adalah game MOBA PC yang kompleks. Bergabunglah dengan tim kami dan kuasai strategi pertempuran!',
                'image' => 'images/games/dota2.jpg',
                'slug' => 'dota-2',
                'status' => 'active'
            ]
        ];

        foreach ($games as $game) {
            Game::create($game);
        }
    }
} 
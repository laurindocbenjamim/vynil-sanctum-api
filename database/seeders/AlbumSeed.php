<?php

namespace Database\Seeders;

use App\Models\Album;
use Illuminate\Database\Seeder;

class AlbumSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Album::create([
            'title' => '',
            'for_download' => '0',
            'artist_id' => 1,
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        Album::create([
            'title' => '',
            'for_download' => '0',
            'artist_id' => 2,
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        Album::create([
            'title' => '',
            'for_download' => '0',
            'artist_id' => 3,
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}

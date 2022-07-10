<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Seeder;

class ArtistSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artist::create([
            'artist' => 'Mizzy Miles',
            'fullname' => 'Mizzy Miles',
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        Artist::create([
            'artist' => 'Ruilaster',
            'fullname' => 'Ruilaster',
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        Artist::create([
            'artist' => 'Justin Bieber',
            'fullname' => 'Justin Bieber',
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}

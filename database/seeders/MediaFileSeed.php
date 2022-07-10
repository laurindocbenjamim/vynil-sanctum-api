<?php

namespace Database\Seeders;

use App\Models\MediaFile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MediaFileSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MediaFile::create([
            'artist' => 'Mizzy Miles',
            'title' => 'God Mode',
            'feat' => 'Prodigio & Benji Price',
            'track_path' => 'tracks/Mizzy Miles - GOD MODE (feat Prodigio & Benji Price).mp3',
            'track_image' => 'images/pre-logo-soundsense.png',
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        MediaFile::create([
            'artist' => 'Ruilaster',
            'title' => 'Alta Tensão',
            'feat' => 'Tio Edson & Phedilson',
            'track_path' => 'tracks/Ruilaster - Alta Tensão (feat. Tio Edson & Phedilson).mp3',
            'track_image' => 'images/pre-logo-soundsense.png',
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        MediaFile::create([
            'artist' => 'Justin Bieber',
            'title' => 'Lonely',
            'feat' => 'Benny Blanco',
            'track_path' => 'tracks/Justin Bieber & benny blanco - Lonely.mp3',
            'track_image' => 'images/pre-logo-soundsense.png',
            'for_download' => '0',
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

    }
}

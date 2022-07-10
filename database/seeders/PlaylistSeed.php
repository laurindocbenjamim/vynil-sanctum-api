<?php

namespace Database\Seeders;

use App\Models\Playlist;
use Illuminate\Database\Seeder;

class PlaylistSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Playlist::create([
            'name' => 'Default',
            'code_list' => 'default',
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}

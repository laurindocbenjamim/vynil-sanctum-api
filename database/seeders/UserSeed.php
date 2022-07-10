<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin@',
            'email' => 'admin@email.com',
            'avatar' => '',
            'password' => Hash::make('Aliens2090#'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $user->createToken('mediaVynilToken')->plainTextToken;
    }
}

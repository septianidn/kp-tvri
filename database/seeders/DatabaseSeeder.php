<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Septian Cahaya Purnama',
            'phone' => '082312127268',
            'address' => 'Padang',
            'role' => 'Admin',
            'email' => 'septiancahayapurnama@gmail.com',
            'password' => Hash::make('draw7437'),
        ]);
    }
}

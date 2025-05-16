<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah user dengan id 1 sudah ada
        $exists = DB::table('users')->where('id', 1)->exists();

        if (!$exists) {
            DB::table('users')->insert([
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

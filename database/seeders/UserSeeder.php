<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Pegawai;


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

        // Membuat user admin
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Membuat data pegawai terkait user admin
        Pegawai::create([
            'id' => Pegawai::getKodePegawai(), // Menggunakan metode untuk generate ID
            'nama' => 'Admin Pegawai',
            'jenis_kelamin' => 'Laki-laki',
            'no_hp' => '081234567890',
            'posisi' => 'Administrator',
            'shift' => 'Pagi',
            'tanggal_masuk' => '2023-10-01',
            'status_karyawan' => 'Tetap',
            'userId' => $user->id, // Menghubungkan dengan user yang baru dibuat
        ]);

    }
}
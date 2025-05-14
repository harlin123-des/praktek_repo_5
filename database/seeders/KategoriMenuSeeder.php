<?php

namespace Database\Seeders;

use App\Models\KategoriMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriMenu::create([
            'id_kategori' => 'KAT001', 
            'nama_kategori' => 'Makanan',
            'keterangan' => 'Kategori makanan berat'
        ]);
        
        //
    }
}

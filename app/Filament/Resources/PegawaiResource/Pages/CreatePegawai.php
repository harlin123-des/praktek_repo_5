<?php

namespace App\Filament\Resources\PegawaiResource\Pages;

use App\Filament\Resources\PegawaiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class CreatePegawai extends CreateRecord
{
    protected static string $resource = PegawaiResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Simpan data user ke tabel users
        $user = User::create([
            'name' => $data['nama'], // Nama user diambil dari nama pegawai
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // Enkripsi password menggunakan Hash
        ]);

        // Hubungkan user_id ke data pegawai
        $data['userId'] = $user->id;

        // Hapus email dan password dari data pegawai (karena tidak ada kolomnya)
        unset($data['email'], $data['password']);

        return $data;
    }

}

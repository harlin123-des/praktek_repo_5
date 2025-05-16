<?php

namespace App\Filament\Resources\PresensiResource\Pages;

use App\Filament\Resources\PresensiResource;
use App\Models\Pegawai;
use App\Models\Presensi;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListPresensis extends ListRecords
{
    protected static string $resource = PresensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Presensi Masuk')
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $user = auth()->user();
                    $pegawai = Pegawai::where('userId', $user->id)->first();

                    if (!$pegawai) {
                        Notification::make()
                            ->title('Pegawai tidak ditemukan.')
                            ->danger()
                            ->send();
                        return;
                    }

                    $sudahPresensi = Presensi::where('pegawai_id', $pegawai->id)
                        ->where('tanggal', now()->toDateString())
                        ->exists();

                    if ($sudahPresensi) {
                        Notification::make()
                            ->title('Anda sudah presensi hari ini.')
                            ->warning()
                            ->send();
                        return;
                    }

                    Presensi::create([
                        'pegawai_id' => $pegawai->id,
                        'tanggal' => now()->toDateString(),
                        'jam_masuk' => now()->toTimeString(),
                        'status' => 'Hadir',
                    ]);

                    Notification::make()
                        ->title('Presensi masuk berhasil.')
                        ->success()
                        ->send();
                }),

            Actions\Action::make('Presensi Keluar')
                ->color('warning')
                ->requiresConfirmation()
                ->action(function () {
                    $user = auth()->user();
                    $pegawai = Pegawai::where('userId', $user->id)->first();

                    if (!$pegawai) {
                        Notification::make()
                            ->title('Pegawai tidak ditemukan.')
                            ->danger()
                            ->send();
                        return;
                    }

                    $presensi = Presensi::where('pegawai_id', $pegawai->id)
                        ->where('tanggal', now()->toDateString())
                        ->whereNull('jam_keluar')
                        ->first();

                    if (!$presensi) {
                        Notification::make()
                            ->title('Belum presensi masuk atau sudah presensi keluar.')
                            ->warning()
                            ->send();
                        return;
                    }

                    $presensi->update([
                        'jam_keluar' => now()->toTimeString(),
                    ]);

                    Notification::make()
                        ->title('Presensi keluar berhasil.')
                        ->success()
                        ->send();
                }),
        ];
    }
}

<?php

namespace App\Filament\Resources\PresensiResource\Pages;

use App\Filament\Resources\PresensiResource;

use App\Models\Pegawai;
use App\Models\Presensi;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use App\Models\Presensi;
use Carbon\Carbon;


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

            Action::make('Presensi Masuk')
                ->visible(fn() => !$this->sudahPresensiMasuk())
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $this->handlePresensiMasuk();
                }),

            Action::make('Presensi Keluar')
                ->visible(fn() => $this->sudahPresensiMasuk() && !$this->sudahPresensiKeluar())
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    $this->handlePresensiKeluar();
                }),
        ];
    }

    protected function sudahPresensiMasuk(): bool
    {
        $user = Auth::user();
        if (!$user || !$user->pegawai) {
            return false;
        }

        return Presensi::where('pegawai_id', $user->pegawai->id)
            ->whereDate('tanggal', Carbon::now()->toDateString())
            ->exists();
    }

    protected function sudahPresensiKeluar(): bool
    {
        $user = Auth::user();
        if (!$user || !$user->pegawai) {
            return false;
        }

        $presensi = Presensi::where('pegawai_id', $user->pegawai->id)
            ->whereDate('tanggal', Carbon::now()->toDateString())
            ->first();

        return $presensi && $presensi->jam_keluar !== null;
    }

    private function handlePresensiMasuk(): void
    {
        $user = Auth::user();
        if (!$user || !$user->pegawai) {
            return;
        }

        $pegawaiId = $user->pegawai->id;
        $now = Carbon::now('Asia/Jakarta');

        $jamMasuk = $now->toTimeString();
        // $batasJamMasuk = Carbon::createFromTime(8, 0, 0);
        // $keterangan = $now->lessThanOrEqualTo($batasJamMasuk)
        //     ? 'Tepat waktu'
        //     : 'Terlambat ' . $now->diff($batasJamMasuk)->format('%h jam %i menit');

        Presensi::create([
            'pegawai_id' => $pegawaiId,
            'tanggal' => $now->toDateString(),
            'jam_masuk' => $jamMasuk,
            // 'keterangan' => $keterangan,
        ]);
    }

    private function handlePresensiKeluar(): void
    {
        $user = Auth::user();
        if (!$user || !$user->pegawai) {
            return;
        }

        $pegawaiId = $user->pegawai->id;
        $now = Carbon::now('Asia/Jakarta');

        $presensi = Presensi::where('pegawai_id', $pegawaiId)
            ->whereDate('tanggal', $now->toDateString())
            ->first();

        if ($presensi && !$presensi->jam_keluar) {
            // Update keterangan dan status
            $jamMasuk = Carbon::createFromTimeString($presensi->jam_masuk);
            $batasJamMasuk = Carbon::createFromTime(8, 0, 0); // Jam 08:00 WIB
            $keterangan = $jamMasuk->lessThanOrEqualTo($batasJamMasuk)
                ? 'Tepat waktu'
                : 'Terlambat ' . $jamMasuk->diff($batasJamMasuk)->format('%h jam %i menit');

            $presensi->update([
                'jam_keluar' => $now->toTimeString(),
                'status' => 'Hadir', // Isi kolom status dengan enum "Hadir"
                'keterangan' => $keterangan, // Update keterangan jika diperlukan
            ]);
        }
    }
}


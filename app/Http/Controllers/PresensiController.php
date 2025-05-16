<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function masuk(Request $request)
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('userId', $user->id)->first();

        if (!$pegawai) {
            return response()->json(['error' => 'Pegawai tidak ditemukan'], 404);
        }

        $today = date('Y-m-d');

        $presensiHariIni = Presensi::where('pegawai_id', $pegawai->id)
            ->where('tanggal', $today)
            ->first();

        if ($presensiHariIni) {
            return response()->json(['error' => 'Sudah presensi hari ini'], 400);
        }

        Presensi::create([
            'tanggal' => $today,
            'jam_masuk' => date('H:i:s'),
            'status' => 'Hadir',
            'pegawai_id' => $pegawai->id,
        ]);

        return response()->json(['success' => 'Presensi masuk berhasil']);
    }

    public function keluar(Request $request)
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('userId', $user->id)->first();

        if (!$pegawai) {
            return response()->json(['error' => 'Pegawai tidak ditemukan'], 404);
        }

        $today = date('Y-m-d');

        $presensiHariIni = Presensi::where('pegawai_id', $pegawai->id)
            ->where('tanggal', $today)
            ->first();

        if (!$presensiHariIni) {
            return response()->json(['error' => 'Belum presensi masuk hari ini'], 400);
        }

        if ($presensiHariIni->jam_keluar) {
            return response()->json(['error' => 'Sudah presensi keluar hari ini'], 400);
        }

        $presensiHariIni->update([
            'jam_keluar' => date('H:i:s'),
        ]);

        return response()->json(['success' => 'Presensi keluar berhasil']);
    }
}

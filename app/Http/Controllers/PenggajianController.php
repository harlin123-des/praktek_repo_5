<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penggajian;
use App\Models\Pegawai;
use App\Models\Presensi;
use Carbon\Carbon;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajians = Penggajian::with('pegawai')->get();
        return view('penggajians.index', compact('penggajians'));
    }

    public function create()
    {
        $pegawais = Pegawai::all();
        return view('penggajians.create', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000',
            'gaji_pokok' => 'required|numeric',
            'tunjangan' => 'nullable|numeric',
            'potongan' => 'nullable|numeric',
        ]);

        $presensis = Presensi::where('pegawai_id', $request->pegawai_id)
            ->whereMonth('tanggal', $request->bulan)
            ->whereYear('tanggal', $request->tahun)
            ->where('status', 'hadir')
            ->get();

        $totalJam = 0;

        foreach ($presensis as $presensi) {
            $jamMasuk = Carbon::parse($presensi->jam_masuk);
            $jamKeluar = Carbon::parse($presensi->jam_keluar);
            $selisihJam = $jamKeluar->diffInHours($jamMasuk);
            $totalJam += $selisihJam;
        }

        $gajiPerJam = 75000;
        $gajiDariPresensi = $totalJam * $gajiPerJam;

        $totalGaji = $gajiDariPresensi + ($request->tunjangan ?? 0) - ($request->potongan ?? 0);

        Penggajian::create([
            'pegawai_id' => $request->pegawai_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'gaji_pokok' => $request->gaji_pokok,
            'tunjangan' => $request->tunjangan ?? 0,
            'potongan' => $request->potongan ?? 0,
            'total_gaji' => $totalGaji,
        ]);

        return redirect()->route('penggajian.index')->with('success', 'Data penggajian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $pegawais = Pegawai::all();
        return view('penggajians.edit', compact('penggajian', 'pegawais'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'gaji_pokok' => 'required|numeric',
            'tunjangan' => 'nullable|numeric',
            'potongan' => 'nullable|numeric',
        ]);

        $penggajian = Penggajian::findOrFail($id);

        $presensis = Presensi::where('pegawai_id', $request->pegawai_id)
            ->whereMonth('tanggal', $penggajian->bulan)
            ->whereYear('tanggal', $penggajian->tahun)
            ->where('status', 'hadir')
            ->get();

        $totalJam = 0;

        foreach ($presensis as $presensi) {
            $jamMasuk = Carbon::parse($presensi->jam_masuk);
            $jamKeluar = Carbon::parse($presensi->jam_keluar);
            $selisihJam = $jamKeluar->diffInHours($jamMasuk);
            $totalJam += $selisihJam;
        }

        $gajiPerJam = 75000;
        $gajiDariPresensi = $totalJam * $gajiPerJam;

        $totalGaji = $gajiDariPresensi + ($request->tunjangan ?? 0) - ($request->potongan ?? 0);

        $penggajian->update([
            'pegawai_id' => $request->pegawai_id,
            'gaji_pokok' => $request->gaji_pokok,
            'tunjangan' => $request->tunjangan ?? 0,
            'potongan' => $request->potongan ?? 0,
            'total_gaji' => $totalGaji,
        ]);

        return redirect()->route('penggajian.index')->with('success', 'Data penggajian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $penggajian->delete();

        return redirect()->route('penggajian.index')->with('success', 'Data penggajian berhasil dihapus.');
    }
}

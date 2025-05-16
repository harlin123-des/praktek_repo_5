<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Tampilkan daftar pegawai (opsional)
        $pegawais = Pegawai::all();
        return view('pegawais.index', compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pegawais.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'no_hp' => 'required|string',
            'posisi' => 'required|string',
            'shift' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'status_karyawan' => 'required|string',
        ]);

        Pegawai::create([
            'id' => $request->id,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'posisi' => $request->posisi,
            'shift' => $request->shift,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status_karyawan' => $request->status_karyawan,
            'userId' => auth()->id() ?? 1, // fallback ke 1 jika belum login
        ]);

        return redirect()->route('pegawais.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawais.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawais.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'no_hp' => 'required|string',
            'posisi' => 'required|string',
            'shift' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'status_karyawan' => 'required|string',
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'posisi' => $request->posisi,
            'shift' => $request->shift,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status_karyawan' => $request->status_karyawan,
        ]);

        return redirect()->route('pegawais.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect()->route('pegawais.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}

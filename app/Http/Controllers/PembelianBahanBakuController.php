<?php

namespace App\Http\Controllers;

use App\Models\PembelianBahanBaku;
use Illuminate\Http\Request;

class PembelianBahanBakuController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'pembelian_id' => 'required',
            'bahan_baku_id' => 'required',
            'jumlah' => 'required|numeric',
            'harga_satuan' => 'required|numeric',
        ]);

        PembelianBahanBaku::create($validated);

        return response()->json(['message' => 'Pembelian bahan baku berhasil disimpan']);
    }
}

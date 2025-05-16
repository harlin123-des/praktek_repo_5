<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use App\Models\Pengirimanemail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class PengirimanEmailController extends Controller
{
    public function proses_kirim_email_pembayaran()
    {
        $data = DB::table('penjualan')
            ->join('users', 'penjualan.user_id', '=', 'users.id')
            ->where('penjualan.status', 'bayar')
            ->whereNotIn('penjualan.id', function ($query) {
                $query->select('penjualan_id')->from('pengirimanemail');
            })
            ->select('penjualan.id', 'penjualan.no_faktur', 'penjualan.nama_pembeli', 'users.email')
            ->get();

        foreach ($data as $p) {
            $id = $p->id;
            $no_faktur = $p->no_faktur;
            $nama_pembeli = $p->nama_pembeli;
            $email = $p->email;

            $barang = DB::table('penjualan_menu')
                ->join('menu', 'penjualan_menu.menu_id', '=', 'menu.id_menu')
                ->where('penjualan_menu.penjualan_id', $id)
                ->select(
                    'menu.nama_menu',
                    'penjualan_menu.harga_jual',
                    'penjualan_menu.jml',
                    DB::raw('(penjualan_menu.harga_jual * penjualan_menu.jml) as total_harga')
                )->get();

            $pdf = Pdf::loadView('pdf.invoice', [
                'no_faktur' => $no_faktur,
                'nama_pembeli' => $nama_pembeli,
                'items' => $barang,
                'total' => $barang->sum('total_harga'),
                'tanggal' => now()->format('d-m-Y'),
            ]);

            $dataAtributPelanggan = [
                'customer_name' => $nama_pembeli,
                'invoice_number' => $no_faktur
            ];

            Mail::to($email)->send(new InvoiceMail($dataAtributPelanggan, $pdf->output()));

            Pengirimanemail::create([
                'penjualan_id' => $id,
                'status' => 'sudah terkirim',
                'tgl_pengiriman_pesan' => now(),
            ]);

            sleep(3); // Hindari spam
        }

        return response("Semua email berhasil dikirim.");
    }
}

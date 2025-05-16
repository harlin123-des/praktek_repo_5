<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\InvoiceMail;

class InvoiceController extends Controller
{
    public function sendInvoice()
    {
        // Contoh data invoice
        $data = [
            'no_faktur' => 'F-00002',
            'nama_pembeli' => 'Ryan',
            'tanggal' => now()->format('d-M-Y'),
            'items' => [
                (object)[
                    'nama_menu' => 'Dimsum Ayam',
                    'jml' => 2,
                    'harga_jual' => 25000,
                    'total_harga' => 50000,
                ],
                (object)[
                    'nama_menu' => 'Teh Manis',
                    'jml' => 1,
                    'harga_jual' => 10000,
                    'total_harga' => 10000,
                ],
            ],
            'total' => 60000,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('pdf.invoice', $data);

        // Kirim email dengan attachment PDF
        Mail::to('your-email@example.com')->send(new InvoiceMail($data, $pdf->output()));

        return 'Email invoice sudah dikirim.';
    }
}

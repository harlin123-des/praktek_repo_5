@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Penggajian</h2>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <a href="{{ route('penggajian.create') }}">+ Tambah Penggajian</a>

    <table border="1" cellpadding="8" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>Pegawai</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Gaji Pokok</th>
                <th>Tunjangan</th>
                <th>Potongan</th>
                <th>Total Gaji</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penggajians as $gaji)
                <tr>
                    <td>{{ $gaji->pegawai->nama }}</td>
                    <td>{{ $gaji->bulan }}</td>
                    <td>{{ $gaji->tahun }}</td>
                    <td>Rp{{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($gaji->tunjangan, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                    <td><strong>Rp{{ number_format($gaji->total_gaji, 0, ',', '.') }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

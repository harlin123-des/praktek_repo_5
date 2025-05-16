<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daftar Penjualan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #333;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h2>Daftar Penjualan</h2>
    <table>
        <thead>
            <tr>
                <th>No Faktur</th>
                <th>Nama Pembeli</th>
                <th>Status</th>
                <th>Tagihan</th>
                <th>Tgl</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan as $item)
                <tr>
                    <td>{{ $item->no_faktur }}</td>
                    <td>{{ $item->nama_pembeli }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ number_format($item->tagihan, 0, ',', '.') }}</td>
                    <td>{{ $item->tgl }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

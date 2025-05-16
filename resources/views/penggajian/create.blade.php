<!DOCTYPE html>
<html>
<head>
    <title>Form Penggajian</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Form Input Penggajian</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('penggajian.store') }}">
        @csrf

        <div class="mb-3">
            <label for="pegawai_id" class="form-label">Pilih Pegawai:</label>
            <select name="pegawai_id" class="form-select" required>
                <option value="">-- Pilih Pegawai --</option>
                @foreach($pegawais as $pegawai)
                    <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="bulan" class="form-label">Bulan:</label>
            <input type="number" name="bulan" class="form-control" min="1" max="12" required>
        </div>

        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun:</label>
            <input type="number" name="tahun" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="gaji_pokok" class="form-label">Gaji Pokok:</label>
            <input type="number" step="0.01" name="gaji_pokok" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tunjangan" class="form-label">Tunjangan:</label>
            <input type="number" step="0.01" name="tunjangan" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label for="potongan" class="form-label">Potongan:</label>
            <input type="number" step="0.01" name="potongan" class="form-control" value="0">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('penggajian.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>

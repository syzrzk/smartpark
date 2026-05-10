<!DOCTYPE html>
<html>
<head>
    <title>Parkir Masuk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- STYLE -->
    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
        }

        .card {
            border-radius: 20px;
            background: #1e293b;
            color: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border: none;
            border-radius: 12px;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        select {
            background: #0f172a !important;
            color: white !important;
            border-radius: 10px;
        }

        h3 {
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow p-4 w-100" style="max-width: 400px;">

        <h3 class="text-center mb-4">🚗 Parkir Masuk</h3>

        <form action="{{ route('parkir.masuk') }}" method="POST">
         @csrf

            <!-- JENIS KENDARAAN -->
            <div class="mb-3">
                <label class="mb-2">Jenis Kendaraan</label>
                <select name="jenis_kendaraan" class="form-control">
    <option value="motor">Motor</option>
    <option value="mobil">Mobil</option>
</select>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn btn-primary w-100">
                🚀 Generate Tiket Parkir
            </button>
        </form>

        <!-- NAVIGASI -->
        <div class="text-center mt-3">
            <a href="/scan" class="text-info">🔍 Scan QR Keluar</a>
        </div>

    </div>

</div>

</body>
</html>
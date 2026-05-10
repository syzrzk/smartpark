<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartPark Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .card-custom {
            padding: 20px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            transition: 0.3s;
        }

        .card-custom:hover {
            transform: translateY(-5px) scale(1.02);
        }

        .bg1 { background: linear-gradient(135deg,#3b82f6,#60a5fa); }
        .bg2 { background: linear-gradient(135deg,#10b981,#34d399); }
        .bg3 { background: linear-gradient(135deg,#f59e0b,#fbbf24); }
        .bg4 { background: linear-gradient(135deg,#ef4444,#f87171); }

        .chart-box {
            background: rgba(255,255,255,0.05);
            border-radius: 20px;
            padding: 20px;
            margin-top: 20px;
        }

        h2 {
            font-weight: bold;
        }

        h6 {
            opacity: 0.8;
        }
    </style>
</head>

<body>

<div class="container mt-4">

    <!-- HEADER -->
     <nav class="d-flex justify-content-between align-items-center mb-4">
    <h4>🚗 SmartPark</h4>

    <div>
        <a href="/dashboard" class="btn btn-light btn-sm">Dashboard</a>
        <a href="/masuk" class="btn btn-success btn-sm">+ Kendaraan Masuk</a>
        <a href="/scan" class="btn btn-warning btn-sm">Scan QR</a>
        <a href="/logout" class="btn btn-danger btn-sm"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           Logout
        </a>

        <form id="logout-form" action="/logout" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</nav>
    <div class="header">
        <h2>🚗 SmartPark Dashboard</h2>
        <p class="text-light">Monitoring Parkir Real-time</p>
    </div>

    <!-- CARD -->
    <div class="row g-3">

        <div class="col-md-3 col-6">
            <div class="card-custom bg1">
                <h6>Total Kendaraan</h6>
                <h2 id="totalKendaraan">0</h2>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card-custom bg2">
                <h6>Pendapatan</h6>
                <h2 id="totalPendapatan">0</h2>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card-custom bg3">
                <h6>Motor</h6>
                <h2 id="motor">0</h2>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card-custom bg4">
                <h6>Mobil</h6>
                <h2 id="mobil">0</h2>
            </div>
        </div>

    </div>

    <!-- CHART -->
    <div class="row">

        <div class="col-md-6">
            <div class="chart-box">
                <h5>📊 Statistik Kendaraan</h5>
                <canvas id="chart"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart-box">
                <h5>💰 Pendapatan Bulanan</h5>
                <canvas id="chartPendapatan"></canvas>
            </div>
        </div>

    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('chart');

let chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Motor', 'Mobil'],
        datasets: [{
            label: 'Jumlah Kendaraan',
            data: [0, 0],
        }]
    }
});
const bulan = {!! json_encode($pendapatan->pluck('bulan')) !!};
const total = {!! json_encode($pendapatan->pluck('total')) !!};

const chart2 = new Chart(document.getElementById('chartPendapatan'), {
    type: 'line',
    data: {
        labels: bulan,
        datasets: [{
            label: 'Pendapatan',
            data: total,
        }]
    }
});
</script>

<!-- AUTO REFRESH -->
<script>
function loadDashboard() {
    fetch('/api/dashboard')
    .then(res => res.json())
    .then(data => {

        // UPDATE CARD
        document.getElementById('totalKendaraan').innerText = data.totalKendaraan;
        document.getElementById('totalPendapatan').innerText = data.totalPendapatan;
        document.getElementById('motor').innerText = data.motor;
        document.getElementById('mobil').innerText = data.mobil;

        // 🔥 UPDATE CHART
        chart.data.datasets[0].data = [data.motor, data.mobil];
        chart.update('active');
    });
}

setInterval(loadDashboard, 5000);
loadDashboard();
</script>

</body>
</html>
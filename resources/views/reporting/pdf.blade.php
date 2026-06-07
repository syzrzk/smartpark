<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Parkir</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1f2937;
            line-height: 1.6;
        }

        .container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            font-weight: bold;
        }

        .company-name {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
        }

        .company-subtitle {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        .report-title {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .report-period {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 5px;
        }

        .print-date {
            font-size: 11px;
            color: #94a3b8;
            font-style: italic;
        }

        .summary-section {
            margin: 30px 0;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 15px;
        }

        .summary-box {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            background: #f9fafb;
        }

        .summary-label {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .summary-value {
            font-size: 18px;
            font-weight: 700;
            color: #0c4a6e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 10px;
        }

        thead {
            background: #f3f4f6;
        }

        th {
            padding: 10px;
            text-align: center;
            font-weight: 600;
            color: #1f2937;
            border: 1px solid #d1d5db;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        td {
            padding: 10px;
            border: 1px solid #e5e7eb;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        .plat {
            font-weight: 600;
            text-align: left;
            letter-spacing: 0.5px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
        }

        .badge-motor {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-mobil {
            background: #ede9fe;
            color: #5b21b6;
        }

        .badge-member {
            background: #dcfce7;
            color: #166534;
        }

        .badge-non-member {
            background: #fee2e2;
            color: #991b1b;
        }

        .currency {
            font-weight: 600;
            text-align: right;
            color: #059669;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #64748b;
        }

        .page-number {
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            margin-top: 20px;
        }

        @page {
            margin: 15mm;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header">
            <div class="logo-section">
                <div class="logo">P</div>
                <div>
                    <div class="company-name">SmartPark</div>
                    <div class="company-subtitle">Parking Management System</div>
                </div>
            </div>
            <div class="report-title">Laporan Parkir</div>
            <div class="report-period">
                @if($tanggal_awal !== '-' && $tanggal_akhir !== '-')
                    Periode: {{ $tanggal_awal }} hingga {{ $tanggal_akhir }}
                @else
                    Semua Periode
                @endif
            </div>
            <div class="print-date">Dicetak pada: {{ $tanggal_cetak }}</div>
        </div>

        {{-- Ringkasan --}}
        <div class="summary-section">
            <div class="summary-box">
                <div class="summary-label">Total Kendaraan</div>
                <div class="summary-value">{{ $ringkasan['total_kendaraan'] }}</div>
            </div>
            <div class="summary-box">
                <div class="summary-label">Total Pendapatan</div>
                <div class="summary-value">Rp {{ number_format($ringkasan['total_pendapatan'], 0, ',', '.') }}</div>
            </div>
            <div class="summary-box">
                <div class="summary-label">Total Member</div>
                <div class="summary-value">{{ $ringkasan['total_member'] }}</div>
            </div>
            <div class="summary-box">
                <div class="summary-label">Total Non Member</div>
                <div class="summary-value">{{ $ringkasan['total_non_member'] }}</div>
            </div>
        </div>

        {{-- Tabel Data --}}
        <table>
            <thead>
                <tr>
                    <th style="width:5%;">#</th>
                    <th style="width:12%; text-align:left;">Plat Nomor</th>
                    <th style="width:8%;">Jenis</th>
                    <th style="width:15%;">Waktu Masuk</th>
                    <th style="width:15%;">Waktu Keluar</th>
                    <th style="width:8%;">Durasi</th>
                    <th style="width:12%;">Status</th>
                    <th style="width:12%;">Biaya</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($laporan as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td class="plat">{{ optional($item->kendaraan)->plat_nomor ?? '-' }}</td>
                    <td>
                        @if(optional($item->kendaraan)->jenis_kendaraan == 'motor')
                            <span class="badge badge-motor">Motor</span>
                        @elseif(optional($item->kendaraan)->jenis_kendaraan == 'mobil')
                            <span class="badge badge-mobil">Mobil</span>
                        @else
                            <span>-</span>
                        @endif
                    </td>
                    <td>{{ $item->waktu_masuk ? \Carbon\Carbon::parse($item->waktu_masuk)->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $item->waktu_keluar ? \Carbon\Carbon::parse($item->waktu_keluar)->format('d/m/Y H:i') : '-' }}</td>
                    <td>
                        @if($item->waktu_masuk && $item->waktu_keluar)
                            @php $durasi = max(1, ceil(\Carbon\Carbon::parse($item->waktu_masuk)->diffInMinutes($item->waktu_keluar) / 60)); @endphp
                            {{ $durasi }} jam
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($item->status_member)
                            <span class="badge badge-member">✓ Member</span>
                        @else
                            <span class="badge badge-non-member">Non Member</span>
                        @endif
                    </td>
                    <td class="currency">
                        @if($item->status_member)
                            GRATIS
                        @elseif($item->biaya)
                            Rp {{ number_format($item->biaya, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:20px; color:#94a3b8;">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Footer --}}
        <div class="footer">
            <p style="margin-bottom: 10px;">Laporan ini adalah hasil dari Sistem Manajemen Parkir SmartPark</p>
            <p style="font-size: 9px;">© 2026 SmartPark - Semua Hak Dilindungi</p>
        </div>

        <div class="page-number">
            Halaman <span class="page">1</span> dari <span class="total-page">1</span>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Statistik Ringkasan Eksekutif</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #2563eb; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #1e40af; font-size: 24px; }
        .header p { margin: 5px 0 0 0; color: #64748b; font-size: 14px; }
        .stats-container { margin-bottom: 30px; }
        .stat-box { display: inline-block; width: 30%; border: 1px solid #e2e8f0; padding: 15px; margin-right: 2%; text-align: center; border-radius: 8px; background: #f8fafc; }
        .stat-box:last-child { margin-right: 0; }
        .stat-value { font-size: 24px; font-weight: bold; color: #0f172a; margin-top: 10px; }
        .stat-label { font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: bold; }
        .alert { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .safe { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #e2e8f0; padding: 10px; text-align: left; }
        th { background-color: #f1f5f9; color: #475569; font-weight: bold; }
        .footer { position: fixed; bottom: -20px; left: 0px; right: 0px; height: 30px; text-align: right; color: #94a3b8; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Statistik Eksekutif</h1>
        <p>Aplikasi SI-GERDU PANDANG - {{ date('d F Y') }}</p>
    </div>

    <div class="stats-container">
        <div class="stat-box">
            <div class="stat-label">Total Pasien Terdaftar</div>
            <div class="stat-value">{{ number_format($totalPasien) }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Pemeriksaan</div>
            <div class="stat-value">{{ number_format($totalPemeriksaan) }}</div>
        </div>
        <div class="stat-box {{ $pasienHipertensiTidakTerkontrol > 0 ? 'alert' : 'safe' }}">
            <div class="stat-label">HT Tidak Terkontrol (30 Hari)</div>
            <div class="stat-value">{{ number_format($pasienHipertensiTidakTerkontrol) }}</div>
        </div>
    </div>

    <h3>{{ $title }}</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Label</th>
                <th>Total Pasien</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grafikData as $index => $data)
            <tr>
                <td style="width: 50px; text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $data->label }}</td>
                <td style="width: 150px; text-align: right;">{{ number_format($data->total) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register Peserta Prolanis & PRB</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10px; color: #000; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 14px; margin: 0 0 5px 0; padding: 0; }
        .header h2 { font-size: 12px; margin: 0; font-weight: normal; }
        .info-table { width: 100%; margin-bottom: 10px; font-size: 10px; border: none; }
        .info-table td { padding: 2px 5px; border: none; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 4px; text-align: left; vertical-align: top; }
        .data-table th { background-color: #f0f0f0; font-weight: bold; text-align: center; font-size: 9px; }
        .data-table td { font-size: 9px; }
        .text-center { text-align: center; }
        .footer { text-align: right; margin-top: 30px; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REGISTER PESERTA PROLANIS & PRB</h1>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Puskesmas</strong></td>
            <td width="35%">: {{ $puskesmasName }}</td>
            <td width="15%"><strong>Kalurahan</strong></td>
            <td width="35%">: {{ $kalurahanName }}</td>
        </tr>
        <tr>
            <td><strong>Periode</strong></td>
            <td>: {{ isset($filters[0]) ? str_replace('Periode: ', '', $filters[0]) : '-' }}</td>
            <td><strong>Tanggal Cetak</strong></td>
            <td>: {{ date('d-m-Y H:i') }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="3%">NO</th>
                <th width="8%">TANGGAL AWAL</th>
                <th width="8%">NO. RM</th>
                <th width="15%">NAMA</th>
                <th width="10%">NIK</th>
                <th width="8%">TANGGAL LAHIR</th>
                <th width="12%">NAMA KEPALA KELUARGA</th>
                <th width="16%">ALAMAT (DUSUN, RT, RW)</th>
                <th width="8%">NO. HP</th>
                <th width="8%">NO JKN</th>
                <th width="4%">PROLANIS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pasiens as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $p->tanggal_awal_terdaftar ? $p->tanggal_awal_terdaftar->format('d/m/Y') : '-' }}</td>
                <td class="text-center">{{ $p->no_rm ?: '-' }}</td>
                <td>{{ $p->nama_lengkap }}</td>
                <td class="text-center">{{ $p->nik }}</td>
                <td class="text-center">{{ $p->tanggal_lahir ? $p->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                <td>{{ $p->nama_kepala_keluarga }}</td>
                <td>{{ $p->dukuh }} RT {{ $p->rt }}/RW {{ $p->rw }}</td>
                <td class="text-center">{{ $p->no_hp ?: '-' }}</td>
                <td class="text-center">{{ $p->no_jkn ?: '-' }}</td>
                <td class="text-center">{{ $p->jenis_prolanis }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center">Tidak ada data pasien yang sesuai filter.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

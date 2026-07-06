<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan SI GERDU PANDANG</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 0 0 5px 0;
        }
        .subtitle {
            font-size: 12px;
            color: #475569;
            margin: 0;
        }
        .filters {
            margin-bottom: 15px;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #334155;
        }
        .text-center { text-align: center; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">SI GERDU PANDANG</h1>
        <h2 class="subtitle">Laporan Pemeriksaan Kesehatan Terpadu (Hipertensi)</h2>
    </div>

    @if(count($filters) > 0)
    <div class="filters">
        <strong>Filter Diterapkan:</strong><br>
        @foreach($filters as $f)
            - {{ $f }}<br>
        @endforeach
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="8%">Tgl</th>
                <th width="12%">Nama Pasien</th>
                <th width="15%">Puskesmas</th>
                <th width="8%">Tensi</th>
                <th width="10%">Kat. Tensi</th>
                <th width="5%">IMT</th>
                <th width="10%">Status IMT</th>
                <th width="12%">Diagnosis</th>
                <th width="17%">Terapi / Obat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemeriksaans as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $p->tanggal_pemeriksaan->format('d/m/Y') }}</td>
                <td>
                    <strong>{{ $p->pasien->nama_lengkap ?? '-' }}</strong><br>
                    <span style="font-size: 8px; color: #64748b;">{{ $p->pasien->umur ?? '-' }} thn, {{ substr($p->pasien->jenis_kelamin ?? '-', 0, 1) }}</span>
                </td>
                <td>{{ $p->pasien->puskesmas->nama_puskesmas ?? '-' }}</td>
                <td class="text-center">{{ $p->systole }}/{{ $p->diastole }}</td>
                <td>{{ $p->kategori_tensi }}</td>
                <td class="text-center">{{ $p->imt }}</td>
                <td>{{ $p->status_imt }}</td>
                <td>{{ $p->diagnosis }}</td>
                <td>
                    @if($p->terapiObats && count($p->terapiObats) > 0)
                        <ul style="margin: 0; padding-left: 12px; font-size: 9px;">
                        @foreach($p->terapiObats as $ob)
                            <li>{{ $ob->nama_obat }} ({{ $ob->aturan_pakai }})</li>
                        @endforeach
                        </ul>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center" style="padding: 20px;">Tidak ada data pada periode/filter ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }} oleh {{ $user->name }}</p>
    </div>
</body>
</html>

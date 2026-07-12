<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekam Medis - {{ $pemeriksaan->pasien->nama_lengkap ?? 'Unknown' }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; margin: 0; }
        .subtitle { font-size: 12px; color: #666; margin: 5px 0 0 0; }
        .section-title { font-size: 14px; font-weight: bold; background-color: #f0f0f0; padding: 5px; margin-top: 20px; border: 1px solid #ddd; }
        .info-table, .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .info-table td { padding: 5px; vertical-align: top; }
        .info-table td.label { width: 30%; font-weight: bold; }
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .data-table th { background-color: #f9f9f9; font-weight: bold; }
        .footer { margin-top: 40px; text-align: right; }
        .signature { margin-top: 60px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="title">LEMBAR REKAM MEDIS PASIEN</h1>
        <p class="subtitle">Sistem Informasi Gerakan Terpadu Penanganan Penyakit Tidak Menular (SI-GERDU PANDANG)</p>
    </div>

    <div class="section-title">IDENTITAS PASIEN</div>
    <table class="info-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td>: {{ $pemeriksaan->pasien->nama_lengkap ?? '-' }}</td>
            <td class="label">NIK</td>
            <td>: {{ $pemeriksaan->pasien->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td>: {{ $pemeriksaan->pasien->jenis_kelamin ?? '-' }}</td>
            <td class="label">Usia</td>
            <td>: {{ $pemeriksaan->pasien->umur ?? '-' }} Tahun</td>
        </tr>
        <tr>
            <td class="label">Domisili</td>
            <td colspan="3">: {{ $pemeriksaan->pasien->kelurahan->nama_kelurahan ?? '-' }} {{ $pemeriksaan->pasien->dukuhM ? ', '.$pemeriksaan->pasien->dukuhM->nama_dukuh : '' }}</td>
        </tr>
    </table>

    <div class="section-title">DATA PEMERIKSAAN KLINIS</div>
    <table class="info-table">
        <tr>
            <td class="label">Tanggal & Tempat</td>
            <td colspan="3">: {{ $pemeriksaan->tanggal_pemeriksaan->format('d/m/Y') }} di {{ $pemeriksaan->tempat_pemeriksaan }}</td>
        </tr>
        <tr>
            <td class="label">Keluhan Utama</td>
            <td colspan="3">: {{ $pemeriksaan->keluhan }}</td>
        </tr>
    </table>

    <table class="data-table" style="margin-top: 15px;">
        <tr>
            <th width="25%">Fisik & Vital</th>
            <th width="25%">Hasil</th>
            <th width="25%">Laboratorium</th>
            <th width="25%">Hasil</th>
        </tr>
        <tr>
            <td>Tekanan Darah</td>
            <td>{{ $pemeriksaan->systole }} / {{ $pemeriksaan->diastole }} mmHg<br><small>({{ $pemeriksaan->kategori_tensi }})</small></td>
            <td>Gula Darah (GDS)</td>
            <td>{{ $pemeriksaan->gula_darah_sewaktu ? $pemeriksaan->gula_darah_sewaktu . ' mg/dL' : '-' }}</td>
        </tr>
        <tr>
            <td>Indeks Massa Tubuh</td>
            <td>{{ $pemeriksaan->imt }}<br><small>({{ $pemeriksaan->status_imt }})</small></td>
            <td>Kolesterol Total</td>
            <td>{{ $pemeriksaan->kolesterol_total ? $pemeriksaan->kolesterol_total . ' mg/dL' : '-' }}<br><small>({{ $pemeriksaan->kolesterol_total ? $pemeriksaan->kategori_kolesterol : '' }})</small></td>
        </tr>
        <tr>
            <td>Nadi</td>
            <td>{{ $pemeriksaan->nadi }} x/mnt</td>
            <td>Asam Urat</td>
            <td>{{ $pemeriksaan->asam_urat ? $pemeriksaan->asam_urat . ' mg/dL' : '-' }}</td>
        </tr>
    </table>

    <div class="section-title">KESIMPULAN DIAGNOSIS</div>
    <p style="padding: 10px; border: 1px dashed #666; font-size: 14px; font-weight: bold; text-transform: uppercase;">
        {{ $pemeriksaan->diagnosis }}
    </p>

    <div class="section-title">TERAPI OBAT & RESEP</div>
    @if($pemeriksaan->terapiObats->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th width="40%">Nama Obat</th>
                    <th width="30%">Aturan Pakai</th>
                    <th width="20%">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemeriksaan->terapiObats as $index => $obat)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $obat->nama_obat }}</td>
                    <td>{{ $obat->aturan_pakai }}</td>
                    <td style="text-align: center;">{{ $obat->jumlah_obat }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada obat yang diresepkan.</p>
    @endif

    @if($pemeriksaan->catatan)
    <div style="margin-top: 15px;">
        <strong>Catatan Khusus:</strong>
        <p>{{ $pemeriksaan->catatan }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Petugas Pemeriksa,</p>
        <div class="signature">{{ $pemeriksaan->pemeriksa->name ?? 'Petugas Puskesmas' }}</div>
    </div>

</body>
</html>

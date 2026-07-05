<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Pasien - {{ $pasien->nama_lengkap }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; margin: 0; }
        .subtitle { font-size: 12px; color: #666; margin: 5px 0 0 0; }
        .section-title { font-size: 14px; font-weight: bold; background-color: #f0f0f0; padding: 5px; margin-top: 20px; border: 1px solid #ddd; }
        .info-table, .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .info-table td { padding: 5px; vertical-align: top; }
        .info-table td.label { width: 25%; font-weight: bold; color: #555; }
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 6px; text-align: left; font-size: 11px; }
        .data-table th { background-color: #f9f9f9; font-weight: bold; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="title">PROFIL & RIWAYAT MEDIS PASIEN</h1>
        <p class="subtitle">Sistem Informasi Gerakan Terpadu Penanganan Penyakit Tidak Menular (SI-GERDU PANDANG)</p>
    </div>

    <div class="section-title">IDENTITAS LENGKAP PASIEN</div>
    <table class="info-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td>: {{ $pasien->nama_lengkap }}</td>
            <td class="label">NIK / KK</td>
            <td>: {{ $pasien->nik }} / {{ $pasien->no_kk }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td>: {{ $pasien->jenis_kelamin }}</td>
            <td class="label">Tempat/Tgl Lahir</td>
            <td>: {{ $pasien->tanggal_lahir->format('d-m-Y') }} ({{ $pasien->umur }} Thn)</td>
        </tr>
        <tr>
            <td class="label">Status Kepesertaan</td>
            <td>: {{ $pasien->status_peserta }}</td>
            <td class="label">No JKN / BPJS</td>
            <td>: {{ $pasien->no_jkn ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Prolanis</td>
            <td>: {{ $pasien->jenis_prolanis ?? '-' }}</td>
            <td class="label">Puskesmas Naungan</td>
            <td>: {{ $pasien->puskesmas->nama_puskesmas ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Alamat / Domisili</td>
            <td colspan="3">: {{ $pasien->dukuh ? 'Dusun '.$pasien->dukuh : '' }} {{ $pasien->rt ? 'RT '.$pasien->rt : '' }}{{ $pasien->rw ? '/RW '.$pasien->rw : '' }}, Kalurahan {{ $pasien->kalurahan }}</td>
        </tr>
    </table>

    <div class="section-title">RIWAYAT KUNJUNGAN & PEMERIKSAAN KLINIS</div>
    @if($pasien->pemeriksaans->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th width="12%">Tanggal</th>
                    <th width="12%">Tempat</th>
                    <th width="18%">Tensi & IMT</th>
                    <th width="20%">Keluhan Utama</th>
                    <th width="18%">Diagnosis</th>
                    <th width="20%">Terapi Obat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pasien->pemeriksaans as $pem)
                <tr>
                    <td class="text-center">{{ $pem->tanggal_pemeriksaan->format('d/m/Y') }}</td>
                    <td>{{ $pem->tempat_pemeriksaan }}</td>
                    <td>
                        Tensi: {{ $pem->systole }}/{{ $pem->diastole }} <br>
                        IMT: {{ $pem->imt }}
                    </td>
                    <td>{{ $pem->keluhan }}</td>
                    <td style="font-weight: bold;">{{ $pem->diagnosis }}</td>
                    <td>
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($pem->terapiObats as $obat)
                                <li>{{ $obat->nama_obat }} ({{ $obat->aturan_pakai }})</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="padding: 10px; border: 1px dashed #ccc; text-align: center; color: #777;">
            Belum ada riwayat pemeriksaan untuk pasien ini.
        </p>
    @endif

</body>
</html>
